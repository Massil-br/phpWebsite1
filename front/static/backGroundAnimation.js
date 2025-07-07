
/** @type {HTMLCanvasElement} */
const canvas= document.getElementById('background');
/** @type {CanvasRenderingContext2D} */
const ctx = canvas.getContext('2d');
const rootStyles = getComputedStyle(document.documentElement);
const backgroundColor = rootStyles.getPropertyValue('--background-color').trim();

function resizeCanva(){
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}
resizeCanva();
window.addEventListener('resize', resizeCanva);



class Line{
    constructor(){
        this.x = Math.random()*canvas.width;
        this.y = Math.random()*canvas.height;
        this.dir = Math.random() < 0.5 ? 0 : Math.PI /2;
        this.speed = 2+Math.random() *300;
        this.length = 30;
    }

    update(deltaTime){
        const distance = this.speed * deltaTime;
        this.x +=Math.cos(this.dir) * distance;
        this.y += Math.sin(this.dir) * distance;

        if (Math.random()<0.001){
            this.dir += Math.PI/2;
        }

        if(this.x <= 0 || this.x >= canvas.width){
            this.dir = Math.PI - this.dir;
        }
        if (this.y <= 0 || this.y >= canvas.height)this.dir = -this.dir;
    }

    draw(){
        ctx.beginPath();
        ctx.moveTo(this.x, this.y);
        ctx.lineTo(
            this.x + Math.cos(this.dir) * this.length,
            this.y + Math.sin(this.dir) * this.length
        );
        ctx.strokeStyle = 'black';
        ctx.lineWidth = 2;
        ctx.stroke();
    }
}

const lines = Array.from({length : 15}, () =>new Line());

let lastTime = 0;

const fps = 60;
const interval = 1000/fps;


function animate(now){
    requestAnimationFrame(animate);
    const deltaMs = now - lastTime;
    if (deltaMs < interval) return;

    const deltaTime = deltaMs /1000;
    lastTime = now;

    ctx.fillStyle = backgroundColor;
    ctx.fillRect(0,0,canvas.width, canvas.height);
    for(const line of lines){
        line.update(deltaTime);
        line.draw();
    }

   
}

 requestAnimationFrame(animate);

