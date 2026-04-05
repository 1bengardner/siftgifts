const { Engine, Render, World, Bodies, Body, Events } = Matter;

const jar = document.getElementById('jar-container');
const totalLabel = document.getElementById('total');
let totalAmount = 0;

// Initialize Matter.js engine
const engine = Engine.create();
const world = engine.world;

// Invisible floor and walls for the jar
const width = jar.clientWidth;
const height = jar.clientHeight;

const floor = Bodies.rectangle(width/2, height + 10, width, 20, { isStatic: true });
const leftWall = Bodies.rectangle(-10, height/2, 20, height, { isStatic: true });
const rightWall = Bodies.rectangle(width+10, height/2, 20, height, { isStatic: true });

World.add(world, [floor, leftWall, rightWall]);

Engine.run(engine);

// Utility to create paper element and body
function createPaper(contribution) {
    const div = document.createElement('div');
    div.className = 'paper';
    div.textContent = `${contribution.source} $${contribution.amount}`;
    jar.appendChild(div);

    const body = Bodies.rectangle(Math.random() * width, -20, 50, 20, { restitution: 0.3, friction: 0.2 });
    World.add(world, body);

    // Sync DOM element with physics body
    Events.on(engine, 'afterUpdate', () => {
        div.style.left = body.position.x - 25 + 'px';
        div.style.top = body.position.y - 10 + 'px';
        div.style.transform = `rotate(${body.angle}rad)`;
    });

    totalAmount += parseFloat(contribution.amount);
    totalLabel.textContent = `Total: $${totalAmount.toFixed(2)}`;
}

// Handle form submission
document.getElementById('submit').addEventListener('click', () => {
    const source = document.getElementById('source').value.trim();
    const amount = parseFloat(document.getElementById('amount').value);

    if (!source || isNaN(amount)) return alert('Invalid input');

    const formData = new FormData();
    formData.append('fund_id', 1); // assuming fund 1 for now
    formData.append('source', source);
    formData.append('amount', amount);

    fetch('add_contribution.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) createPaper(data.contribution);
            else alert(data.error || 'Error adding contribution');
        })
        .catch(err => alert('Network error'));
});