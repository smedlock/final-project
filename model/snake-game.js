function gameBoard(width, height, cellSize) {
    // add an exception here later
    if (width % cellSize != 0 || height % cellSize != 0) {
        console.log("width or height are not divisible by the cell size");
    }
    this.width = width;
    this.height = height;
    this.cellSize = cellSize;
}

var board = new gameBoard(400, 400, 20);

function snakeCell(x, y, snakeSize, gap, background) {
    this.x = x;
    this.y = y;
    this.element = document.createElement("div");
    this.element.style.width = snakeSize - gap + "px";
    this.element.style.height = snakeSize - gap + "px";
    this.element.style.background = background;
    this.element.style.position = "absolute";

    //this.changeXY = function(x, y) {
    //    this.x = x;
    //    this.y = y;
    //}
}

var snake1 = new snakeCell(41, 81);

var newElement1 = document.createElement("div");
newElement1.style.width = "18px";
newElement1.style.height = "18px";
newElement1.style.background = "white";
newElement1.style.position = "absolute";
newElement1.style.top = snake1.x + 'px';
newElement1.style.left = snake1.y + 'px';
document.getElementById("container").appendChild(newElement1);

console.log("we triedaaasd");

var direction = 1; // 0 up, 1 right, 2 down, 3 left

var elements = [];

for (i = 0; i < 5; i++) {
    elements[i] = document.createElement("div");
    elements[i].style.width = "18px";
    elements[i].style.height = "18px";
    elements[i].style.background = "white";
    elements[i].style.position = "absolute";
    elements[i].style.top = 101 + 'px';
    elements[i].style.left = 1 + 20 * i + 'px';
    document.getElementById("container").appendChild(elements[i]);
}
//var div = document.createElement("div");
//div.style.width = "18px";
//div.style.height = "18px";
//div.style.background = "white";
//div.style.position = "absolute";
//div.style.top = 1 + 'px';
//div.style.left = 101 + 'px';

//document.getElementById("container").appendChild(div);




document.addEventListener('keydown', function(event) {
    console.log("we pressed the down key " + event.keyCode);
    if (event.keyCode == 87) {
        direction = 0;
    } else if (event.keyCode == 68) {
        direction = 1;
    } else if (event.keyCode == 83) {
        direction = 2;
    } else if (event.keyCode == 65) {
        direction = 3;
    }
});

function myMove() {
    //var elem = document.getElementById("animate");
    var elem = elements[elements.length - 1];
    var posX = 80;
    var posY = 100;
    var id = setInterval(frame, 250);
    function frame() {
        /*if (pos == 350) {
            clearInterval(id);
        } else {
            pos++;
            elem.style.top = pos + 'px';
            elem.style.left = pos + 'px';
        }*/
        elem = elements.shift();
        if (direction == 0) {
            posY -= 20;
        } else if (direction == 1) {
            posX += 20;
        } else if (direction == 2) {
            posY += 20;
        } else {
            posX -= 20;
        }
        elem.style.top = 1 + posY + 'px';
        elem.style.left = 1 + posX + 'px';
        elements.push(elem);
    }
}