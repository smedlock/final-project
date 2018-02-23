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
    this.element.style.width = snakeSize - 2 * gap + "px";
    this.element.style.height = snakeSize - 2 * gap + "px";
    this.element.style.background = background;
    this.element.style.position = "absolute";

    //this.changeXY = function(x, y) {
    //    this.x = x;
    //    this.y = y;
    //}
}

//var snake1 = new snakeCell(41, 81);

//var newElement1 = document.createElement("div");
//newElement1.style.width = "18px";
//newElement1.style.height = "18px";
//newElement1.style.background = "white";
//newElement1.style.position = "absolute";
//newElement1.style.top = snake1.x + 'px';
//newElement1.style.left = snake1.y + 'px';
//document.getElementById("container").appendChild(newElement1);

console.log("we triedf");

var direction = 1; // 0 up, 1 right, 2 down, 3 left

var elements = [];
var snakeCells = [];
for (i = 0; i < 6; i++) {
    snakeCells[i] = new snakeCell(5 + i, 10, 20, 1, "white");
    snakeCells[i].element.style.top = snakeCells[i].y * board.cellSize + 1 + "px";
    snakeCells[i].element.style.left = snakeCells[i].x * board.cellSize + 1 + "px";
    document.getElementById("gameboard").appendChild(snakeCells[i].element);
}

var gameboard = document.getElementById("gameboard");
gameboard.style.background = "black";
gameboard.style.width = "400px";
gameboard.style.height = "400px";

for (i = 0; i < 5; i++) {
    elements[i] = document.createElement("div");
    elements[i].style.width = "18px";
    elements[i].style.height = "18px";
    elements[i].style.background = "white";
    elements[i].style.position = "absolute";
    elements[i].style.top = 101 + 'px';
    elements[i].style.left = 1 + 20 * i + 'px';
    document.getElementById("gameboard").appendChild(elements[i]);
}

document.addEventListener('keydown', function(event) {
    if (event.keyCode == 87) { // w
        direction = 0;
    } else if (event.keyCode == 68) { // d
        direction = 1;
    } else if (event.keyCode == 83) { // s
        direction = 2;
    } else if (event.keyCode == 65) { // a
        direction = 3;
    }
});

function startGame() {
    //var elem = document.getElementById("animate");
    var elem = elements[elements.length - 1];
    var posX = 200;
    var posY = 200;
    var id = setInterval(frame, 250);
    function frame() {

        // cases:   head is in empty space
        //          head collides with wall or itself
        //          head is on same cell as food
        /*
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
        */

        snakeElem = snakeCells.shift();
        if (direction == 0) {
            posY -= 20;
        } else if (direction == 1) {
            posX += 20;
        } else if (direction == 2) {
            posY += 20;
        } else {
            posX -= 20;
        }
        snakeElem.element.style.top = 1 + posY + 'px';
        snakeElem.element.style.left = 1 + posX + 'px';
        snakeCells.push(snakeElem);
    }
}

gameboard.addEventListener("click", startGame);