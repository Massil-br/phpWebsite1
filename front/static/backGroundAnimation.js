const canvas= document.getElementById('background');
const ctx = canvas.getContext('2d');


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
        this.speed = 2+Math.random() *0.5;
        this.length = 20;
    }

    update(){
        this.x +=Math.cos(this.dir) * this.speed;
        this.y += Math.sin(this.dir) * this.speed;

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
        ctx.strokeStyle = 'white';
        ctx.lineWidth = 2;
        ctx.stroke();
    }
}

const lines = Array.from({length : 15}, () =>new Line());

function animate(){
    ctx.fillStyle = 'rgba(0,0,0,0.1)';
    ctx.fillRect(0,0,canvas.width, canvas.height);
    for(const line of lines){
        line.update();
        line.draw();
    }

    requestAnimationFrame(animate);
}

animate();