function gameBoard(widthX, heightY, cellSize, gameBoardId) {
    this.widthX = widthX;
    this.heightY = heightY;
    this.headPosX = 0;
    this.headPosY = 0;
    this.lastDirection = 1; // right
    this.snakeCells = []; // the front of the array is the back of the snake
    this.food = new snakeCell(5, 5, 20, 1, "red");
    this.cellSize = cellSize;
    this.gameBoardElement = document.getElementById(gameBoardId);
    this.gameBoardElement.style.background = "black";
    this.gameBoardElement.style.width = this.widthX * cellSize + "px";
    this.gameBoardElement.style.height = this.heightY * cellSize + "px";

    this.move = function(direction) {
        if (direction == 0) {
            this.headPosY -= 1;
            this.lastDirection = 0;
        } else if (direction == 1) {
            this.headPosX += 1;
            this.lastDirection = 1;
        } else if (direction == 2) {
            this.headPosY += 1;
            this.lastDirection = 2;
        } else {
            this.headPosX -= 1;
            this.lastDirection = 3;
        }
    }

    this.collision = function() {
        if (this.headPosX < 0 || this.headPosY < 0 || this.headPosX >= this.widthX || this.headPosY >= this.heightY) {
            return true;
        }
        for (i = 0; i < this.snakeCells.length - 2; i++) {
            if (this.headPosX == this.snakeCells[i].x && this.headPosY == this.snakeCells[i].y) {
                return true;
            }
        }
        return false;
    }

    this.onFood = function() {
        return (this.headPosX == this.food.x && this.headPosY == this.food.y);
    }

    this.moveFood = function() {
        var newX = Math.floor(Math.random() * this.widthX);
        var newY = Math.floor(Math.random() * this.heightY);

        // if food is under the snake, put the food at the back of the snake
        for (i = 0; i < this.snakeCells.length; i++) {
            if (newX == this.snakeCells[i].x && newY == this.snakeCells[i].y) {
                newX = this.snakeCells[0].x;
                newY = this.snakeCells[0].y;
                break;
            }
        }
        this.food.changeXY(newX, newY);
    }
}

function snakeCell(x, y, cellSize, gap, background) {
    this.x = x;
    this.y = y;
    this.element = document.createElement("div");
    this.element.style.width = cellSize - 2 * gap + "px";
    this.element.style.height = cellSize - 2 * gap + "px";
    this.element.style.background = background;
    this.element.style.position = "absolute";
    this.element.style.top = this.y * cellSize + 1 + "px";
    this.element.style.left = this.x * cellSize + 1 + "px";
    document.getElementById("gameboard").appendChild(this.element);

    this.changeXY = function(x, y) {
        this.x = x;
        this.y = y;
        this.element.style.top = 1 + y * cellSize + 'px';
        this.element.style.left = 1 + x * cellSize + 'px';
    }
}

console.log("we tried");

var board = new gameBoard(20, 20, 20, "gameboard");
var direction = 1; // 0 up, 1 right, 2 down, 3 left

// just creating 6 snake blocks
for (i = 0; i < 6; i++) {
    board.snakeCells.push(new snakeCell(5 + i, 10, 20, 1, "green"));
}

document.addEventListener('keydown', function(event) {
    if (event.keyCode == 38 && board.lastDirection != 2) { // up
        direction = 0;
    } else if (event.keyCode == 39 && board.lastDirection != 3) { // right
        direction = 1;
    } else if (event.keyCode == 40 && board.lastDirection != 0) { // down
        direction = 2;
    } else if (event.keyCode == 37 && board.lastDirection != 1) { // left
        direction = 3;
    }
});

function startGame() {
    //var elem = document.getElementById("animate");
    var elem = board.snakeCells[board.snakeCells.length - 1];
    board.headPosX = elem.x;
    board.headPosY = elem.y;
    var id = setInterval(frame, 400);
    function frame() {

        // cases:   head is in empty space
        //          head collides with wall or itself
        //          head is on same cell as food

        board.move(direction);
        if (board.onFood()) {
            board.snakeCells.push(new snakeCell(board.headPosX, board.headPosY, 20, 1, "green"));

            // place food on a random cell
            board.moveFood();
        } else {
            snakeElem = board.snakeCells.shift();
            snakeElem.changeXY(board.headPosX, board.headPosY);
            board.snakeCells.push(snakeElem);
        }
        if (board.collision()) {
            console.log(board.headPosX + " " + board.headPosY);
            elementToRemove = board.snakeCells.pop();
            elementToRemove.element.parentNode.removeChild(elementToRemove.element);
            clearInterval(id);
        }
    }
}

gameboard.addEventListener("click", startGame);


// prevent arrow keys from scrolling
window.addEventListener("keydown", function(e) {
    // arrow keys
    if([37, 38, 39, 40].indexOf(e.keyCode) > -1) {
        e.preventDefault();
    }
}, false);

