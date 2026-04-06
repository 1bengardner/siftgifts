const paperLayer = document.getElementById('paper-layer');
const totalLabel = document.getElementById('total');

let papers = [];
let totalAmount = 0;

// Jar shape function
function getJarBounds(y) {
  // Neck (still slightly narrow)
  if (y < 80) {
    return { left: 115, right: 185 };
  }

  // Aggressive widening
  const t = (y - 80) / 250;

  const width = 70 + t * 150; // MUCH wider

  return {
    left: 150 - width / 2,
    right: 150 + width / 2
  };
}

function hash(str) {
  let hash = 0;
  for (let i = 0; i < str.length; i++) {
    hash = (hash * 31 + str.charCodeAt(i)) >>> 0;
  }
  return hash;
}

// Create paper
function createPaper(c) {
  const g = document.createElementNS("http://www.w3.org/2000/svg", "g");

  const rect = document.createElementNS("http://www.w3.org/2000/svg", "rect");
  const amountText = `$${c.amount.toString().split(".")[1] == "00" ? c.amount.toString().split(".")[0] : c.amount}`;
  const w = 12 + 6 * amountText.length;
  rect.setAttribute("width", w);
  rect.setAttribute("height", 22);
  rect.setAttribute("rx", 3);

  const colors = [
    "#ffffff",     // white
    "#fdf9c8",     // light yellow
    "#c8fafb",     // light blue
    "#fde8f6",     // soft pink
    "#d0ffd8",     // muted green
    "#ebd1ff",     // pastel lavender
    "#ffe8b3",     // light peach
    "#b4e0ff"      // soft sky blue
  ];
  rect.setAttribute("fill", colors[Math.floor(hash(c.source)%colors.length)]);
  rect.setAttribute("stroke", "#abc");

  const text = document.createElementNS("http://www.w3.org/2000/svg", "text");
  text.setAttribute("x", w / 2);
  text.setAttribute("y", 15);
  text.setAttribute("text-anchor", "middle");
  text.setAttribute("font-size", "10");
  text.textContent = amountText;
  text.onclick = function() { this.textContent = this.textContent === amountText ? c.source : amountText };
  text.style.cursor = "pointer";

  g.appendChild(rect);
  g.appendChild(text);
  paperLayer.insertBefore(g, paperLayer.lastElementChild);

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

function shake() {
  for (let p of papers.filter(p => p.settled && p.shaken)) {
    p.settled = false;
    const offset = Math.abs(p.rotation % 180);
    const direction = (offset > 90 ? 1 : -1) * Math.sign(p.rotation);
    p.vr = direction * (2 - 2 * Math.abs(offset - 90) / 90);
    p.vx = (Math.random() - 0.5) * 1.2;
  }
}

function animate() {
  const jarBottom = 355;

  for (let p of papers) {
    if (!p.settled) {
      if (!p.shaken) {
        shake();
        p.shaken = true;
      }
      // Apply slow gravity
      p.vy += 0.02;
      p.y += p.vy;
      p.x += p.vx;
      p.rotation += p.vr;

      // Keep inside jar
      const bounds = getJarBounds(p.y);
      if (p.x < bounds.left) { p.x = bounds.left; }
      if (p.x + p.width > bounds.right) { p.x = bounds.right - p.width; }

      // Determine maximum landing Y (floor or settled paper)
      let landingY = jarBottom - p.height;

      for (let other of papers) {
        if (other === p || !other.settled) continue;

        const dx = Math.abs(p.x - other.x);
        const dy = Math.abs(p.y - other.y);

        const overlapX = dx < (p.width + other.width)/2;
        const overlapY = dy < (p.height + other.height)/2;

        if (overlapX && overlapY) {
          // Adjust landingY to top of the other paper
          landingY = Math.min(landingY, other.y - (p.height + other.height)/4);
        }
      }

      // If we're at or below landing Y, snap
      if (p.y >= landingY) {
        p.y = landingY;
        p.vy = 0;

        // Dampen motion
        p.vx *= 0.95;
        p.vr *= 0.9;

        // Settle if velocities and rotation small
        if (Math.abs(p.vx) < 0.01 && Math.abs(p.vy) < 0.005 && Math.abs(p.vr) < 0.005) {
          p.settled = true;
        }
      }
    }

    // Apply transform
    p.el.setAttribute(
      "transform",
      `translate(${p.x - p.width/2}, ${p.y - p.height/2}) rotate(${p.rotation}, ${p.width/2}, ${p.height/2})`
    );
  }

  requestAnimationFrame(animate);
}

animate();

// Load existing
fetch('get-contributions.php?fund=1')
  .then(res => res.json())
  .then(data => {
    data.forEach((c, i) => {
      setTimeout(() => createPaper(c), i * 80);
    });

    totalAmount = data.reduce((sum, c) => sum + parseFloat(c.amount), 0);
    totalLabel.textContent = `Total: $${totalAmount.toFixed(2)}`;
  })
  .catch(error => {
    notify("There was an error loading contributions.");
    throw error;
  });

function notify(message) {
  document.getElementById("notification-container").innerHTML =
    `<div class="notification-box">
      <div class="error-box">
        <button type="button" class="close-notification" onclick="document.querySelector('.notification-box').remove();">
          ❎
        </button>
        <p>
          ${message}
        </p>
      </div>
    </div>`;
}

// Submit
document.getElementById('submit').addEventListener('click', function() {
  if (!this.form.checkValidity()) return;

  const source = document.getElementById('contribution-source').value.trim();
  const amount = parseFloat(parseFloat(document.getElementById('contribution-amount').value).toFixed(2));

  if (!source || isNaN(amount)) return notify('Please enter a source and a dollar amount.');

  const formData = new FormData();
  formData.append('fund', 1);
  formData.append('source', source);
  formData.append('amount', amount);

  fetch('add-contribution.php', { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        createPaper(data.contribution);
        totalAmount += parseFloat(data.contribution.amount.replace(",", ""));
        totalLabel.textContent = `Total: $${totalAmount.toFixed(2)}`;
      } else {
        throw Error("Error adding funds.");
      }
    })
    .catch(error => {
      notify("There was an error adding your contribution.");
      throw error;
    });
});