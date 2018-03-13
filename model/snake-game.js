const UP = 0;
const RIGHT = 1;
const DOWN = 2;
const LEFT = 3;

function gameBoard(widthX, heightY, cellSize, gameBoardId) {
    this.widthX = widthX;
    this.heightY = heightY;
    this.headPosX;
    this.headPosY;
    this.lastDirection = RIGHT; // right
    this.scores;
    this.snakeCells; // the front of the array is the back of the snake
    this.food;
    this.cellSize = cellSize;
    this.gameBoardElement = document.getElementById(gameBoardId);
    this.gameBoardElement.style.background = "black";
    this.gameBoardElement.style.width = this.widthX * cellSize + "px";
    this.gameBoardElement.style.height = this.heightY * cellSize + "px";

    this.reset = function() {

        // Empty the snake and set to a length of 6 cells
        $("#gameboard").empty();
        this.snakeCells = [];
        for (i = 0; i < 6; i++) {
            this.snakeCells.push(new snakeCell(5 + i, 10, 20, 1, "green"));
        }

        // Reset snake head position
        var lastElem = this.snakeCells[board.snakeCells.length - 1];
        this.headPosX = lastElem.x;
        this.headPosY = lastElem.y;

        // Reset food position
        this.food = new snakeCell(5, 5, 20, 1, "red");
        this.moveFood();

        // Set direction to right
        direction = 1;

        // Get a score board ready for the new game
        this.scores = new scoreBoard(this.snakeCells.length);
    }

    this.move = function(direction) {
        if (direction == UP) {
            this.headPosY -= 1;
            this.lastDirection = UP;
        } else if (direction == RIGHT) {
            this.headPosX += 1;
            this.lastDirection = RIGHT;
        } else if (direction == DOWN) {
            this.headPosY += 1;
            this.lastDirection = DOWN;
        } else {
            this.headPosX -= 1;
            this.lastDirection = LEFT;
        }
        this.scores.cellsTraveled++;
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
    this.gap = gap;
    this.element = document.createElement("div");
    this.element.style.width = cellSize - 2 * gap + "px";
    this.element.style.height = cellSize - 2 * gap + "px";
    this.element.style.background = background;
    this.element.style.position = "absolute";
    this.element.style.top = this.y * cellSize + gap + "px";
    this.element.style.left = this.x * cellSize + gap + "px";
    $("#gameboard").append(this.element);

    this.changeXY = function(x, y) {
        this.x = x;
        this.y = y;
        this.element.style.top = this.gap + y * cellSize + 'px';
        this.element.style.left = this.gap + x * cellSize + 'px';
    }
}

function scoreBoard(snakeLength) {
    this.snakeLength = snakeLength;
    this.foodEaten = 0;
    this.cellsTraveled = 0;
}

console.log("we tried1");

var board = new gameBoard(20, 20, 20, "gameboard");
var direction = RIGHT; // 0 up, 1 right, 2 down, 3 left

$(document).keydown(function(event) {
    if (event.keyCode == 38 && board.lastDirection != DOWN) { // up
        direction = UP;
    } else if (event.keyCode == 39 && board.lastDirection != LEFT) { // right
        direction = RIGHT;
    } else if (event.keyCode == 40 && board.lastDirection != UP) { // down
        direction = DOWN;
    } else if (event.keyCode == 37 && board.lastDirection != RIGHT) { // left
        direction = LEFT;
    }
});

function startGame() {
    board.reset();
    var id = setInterval(frame, 100);
    function frame() {

        // cases:   head is in empty space
        //          head collides with wall or itself
        //          head is on same cell as food

        board.move(direction);
        if (board.onFood()) {
            board.snakeCells.push(new snakeCell(board.headPosX, board.headPosY, 20, 1, "green"));

            board.scores.foodEaten++;
            board.scores.snakeLength++;
            console.log('food eaten: ' + board.scores.foodEaten);
            console.log('snake length: ' + board.scores.snakeLength);
            console.log('cells traveled: ' + board.scores.cellsTraveled);

            // place food on a random cell
            board.moveFood();
        } else {
            snakeElem = board.snakeCells.shift(); // This is an O(n) operation that should be changed eventually
            snakeElem.changeXY(board.headPosX, board.headPosY);
            board.snakeCells.push(snakeElem);
        }
        if (board.collision()) {
            console.log(board.headPosX + " " + board.headPosY);
            elementToRemove = board.snakeCells.pop();
            elementToRemove.element.parentNode.removeChild(elementToRemove.element);

            // AJAX
            $.post(
                "model/update-score.php",
                {snakelength:board.scores.snakeLength},
                function(result) {
                    alert(result);
                }
            )
            // AJAX

            clearInterval(id);
        }
    }
}

$("#gamestart").click(startGame);


// prevent arrow keys from scrolling
window.addEventListener("keydown", function(e) {
    // arrow keys
    if([37, 38, 39, 40].indexOf(e.keyCode) > -1) {
        e.preventDefault();
    }
}, false);

