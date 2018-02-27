function gameBoard(widthX, heightY, cellSize, ) {
    // add an exception here later
    this.widthX = widthX;
    this.heightY = heightY;
    this.headPosX = 0;
    this.headPosY = 0;
    this.snakeCells = [];
    this.cellSize = cellSize;
    this.gameBoardElement;

    this.createGameBoard = function(gameBoardId) {
        this.gameBoardElement = document.getElementById(gameBoardId);
        this.gameBoardElement.style.background = "black";
        this.gameBoardElement.style.width = "400px";
        this.gameBoardElement.style.height = "400px";
    }
}

var board = new gameBoard(20, 20, 20);

function snakeCell(x, y, snakeSize, gap, background) {
    this.x = x;
    this.y = y;
    this.element = document.createElement("div");
    this.element.style.width = snakeSize - 2 * gap + "px";
    this.element.style.height = snakeSize - 2 * gap + "px";
    this.element.style.background = background;
    this.element.style.position = "absolute";

    this.changeXY = function(x, y) {
        this.x = x;
        this.y = y;
        this.element.style.top = 1 + y * snakeSize + 'px';
        this.element.style.left = 1 + x * snakeSize + 'px';
    }

    //this.changeXY = function(x, y) {
    //    this.x = x;
    //    this.y = y;
    //}
}

console.log("we trisedss");

var direction = 1; // 0 up, 1 right, 2 down, 3 left
var snakeCells = [];

for (i = 0; i < 6; i++) {
    snakeCells[i] = new snakeCell(5 + i, 10, 20, 1, "white");
    snakeCells[i].element.style.top = snakeCells[i].y * board.cellSize + 1 + "px";
    snakeCells[i].element.style.left = snakeCells[i].x * board.cellSize + 1 + "px";
    document.getElementById("gameboard").appendChild(snakeCells[i].element);
}

board.createGameBoard("gameboard");

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
    var elem = snakeCells[snakeCells.length - 1];
    var posX = elem.x;
    var posY = elem.y;
    var id = setInterval(frame, 500);
    function frame() {

        // cases:   head is in empty space
        //          head collides with wall or itself
        //          head is on same cell as food

        snakeElem = snakeCells.shift();
        if (direction == 0) {
            posY -= 1;
        } else if (direction == 1) {
            posX += 1;
        } else if (direction == 2) {
            posY += 1;
        } else {
            posX -= 1;
        }
        snakeElem.changeXY(posX, posY);
        snakeCells.push(snakeElem);
    }
}

gameboard.addEventListener("click", startGame);