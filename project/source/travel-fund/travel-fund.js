const paperLayer = document.getElementById('paper-layer');
const totalLabel = document.getElementById('total');

let papers = [];
let totalAmount = 0;

// Jar shape function
function getJarBounds(y) {
  // Neck (still slightly narrow)
  if (y < 110) {
    return { left: 115, right: 185 };
  }

  // Aggressive widening
  const t = (y - 110) / 250;

  const width = 70 + t * 180; // MUCH wider

  return {
    left: 150 - width / 2,
    right: 150 + width / 2
  };
}

// Create paper
function createPaper(c) {
  const g = document.createElementNS("http://www.w3.org/2000/svg", "g");

  const rect = document.createElementNS("http://www.w3.org/2000/svg", "rect");
  rect.setAttribute("width", 70);
  rect.setAttribute("height", 22);
  rect.setAttribute("rx", 3);

  const colors = ["#fff", "#fef9c3", "#e0f2fe"];
  rect.setAttribute("fill", colors[Math.floor(Math.random()*colors.length)]);
  rect.setAttribute("stroke", "#aaa");

  const text = document.createElementNS("http://www.w3.org/2000/svg", "text");
  text.setAttribute("x", 35);
  text.setAttribute("y", 15);
  text.setAttribute("text-anchor", "middle");
  text.setAttribute("font-size", "10");
  text.textContent = `${c.source} $${c.amount}`;

  g.appendChild(rect);
  g.appendChild(text);
  paperLayer.appendChild(g);

  papers.push({
    el: g,
    x: 120 + Math.random() * 60,
    y: 20,
    vx: (Math.random() - 0.5) * 1.2,
    vy: 0.1,
    rotation: Math.random() * 360,
    vr: (Math.random() - 0.5) * 4,
    width: 70,
    height: 22,
    settled: false
  });
}

function animate() {
    const jarBottom = 355;

    for (let p of papers) {
        if (!p.settled) {
            // Apply slow gravity
            p.vy += 0.02;
            p.y += p.vy;
            p.x += p.vx;
            p.rotation += p.vr;

            // Keep inside jar
            const bounds = getJarBounds(p.y);
            if (p.x < bounds.left) { p.x = bounds.left; p.vx *= -0.3; }
            if (p.x + p.width > bounds.right) { p.x = bounds.right - p.width; p.vx *= -0.3; }

            // Determine maximum landing Y (floor or settled paper)
            let landingY = jarBottom - p.height;

            for (let other of papers) {
                if (other === p || !other.settled) continue;

                // Check for horizontal overlap
                const overlapX = p.x + p.width > other.x && p.x < other.x + other.width;

                if (overlapX) {
                    // Candidate landing Y is on top of this paper
                    landingY = Math.min(landingY, other.y - p.height);
                }
            }

            // If we're at or below landing Y, snap
            if (p.y >= landingY) {
                p.y = landingY;
                p.vy = 0;

                // Optional: slide slightly toward jar center for mound effect
                const jarCenter = 150; // jar horizontal center
                p.vx += (jarCenter - (p.x + p.width/2)) * 0.005;

                // Dampen motion
                p.vx *= 0.95;
                p.vr *= 0.9;

                // Settle if velocities small
                if (Math.abs(p.vx) < 0.01 && Math.abs(p.vy) < 0.005) {
                    p.settled = true;
                }
            }
        }

        // Apply transform
        p.el.setAttribute(
            "transform",
            `translate(${p.x}, ${p.y}) rotate(${p.rotation}, ${p.width/2}, ${p.height/2})`
        );
    }

    requestAnimationFrame(animate);
}

animate();

// Load existing
fetch('get_contributions.php?fund_id=1')
  .then(res => res.json())
  .then(data => {
    data.forEach((c, i) => {
      setTimeout(() => createPaper(c), i * 80);
    });

    totalAmount = data.reduce((sum, c) => sum + parseFloat(c.amount), 0);
    totalLabel.textContent = `Total: $${totalAmount.toFixed(2)}`;
  });

// Submit
document.getElementById('submit').addEventListener('click', () => {
  const source = document.getElementById('source').value.trim();
  const amount = parseFloat(document.getElementById('amount').value);

  if (!source || isNaN(amount)) return alert('Invalid input');

  const formData = new FormData();
  formData.append('fund_id', 1);
  formData.append('source', source);
  formData.append('amount', amount);

  fetch('add_contribution.php', { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        createPaper(data.contribution);
        totalAmount += parseFloat(data.contribution.amount);
        totalLabel.textContent = `Total: $${totalAmount.toFixed(2)}`;
      }
    });
});