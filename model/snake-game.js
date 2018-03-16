const UP = 0;
const RIGHT = 1;
const DOWN = 2;
const LEFT = 3;

/**
 * this object stores dimensions and other objects within the game board.
 *
 * @param widthX number of cells in the width of the board
 * @param heightY number of cells in the height of the board
 * @param cellSize size of each cell in pixels
 * @param gameBoardId document's div ID to put the gameBoard in
 */
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

    /**
     * Clears and initializes the board
     */
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
        direction = RIGHT;

        // Get a score board ready for the new game
        this.scores = new scoreBoard(this.snakeCells.length);
    }

    /**
     * Moves the snake in a cardinal direction
     *
     * @param direction the direction to move
     */
    this.move = function(direction) {
        switch (direction) {
            case UP:
                this.headPosY -= 1;
                this.lastDirection = UP;
                break;
            case RIGHT:
                this.headPosX += 1;
                this.lastDirection = RIGHT;
                break;
            case DOWN:
                this.headPosY += 1;
                this.lastDirection = DOWN;
                break;
            default:
                this.headPosX -= 1;
                this.lastDirection = LEFT;
        }
        this.scores.cellsTraveled++;
    }

    /**
     * Checks whether the snake has collided with the wall or itself
     *
     * @returns {boolean} Whether the snake head has collided with a wall or itself
     */
    this.collision = function() {

        // Wall
        if (this.headPosX < 0 || this.headPosY < 0 || this.headPosX >= this.widthX || this.headPosY >= this.heightY) {
            return true;
        }

        // Snake
        for (i = 0; i < this.snakeCells.length - 2; i++) {
            if (this.headPosX == this.snakeCells[i].x && this.headPosY == this.snakeCells[i].y) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks whether the snake head is on a food cell
     *
     * @returns {boolean} Whether the snake head is on a food cell
     */
    this.onFood = function() {
        return (this.headPosX == this.food.x && this.headPosY == this.food.y);
    }

    /**
     * Moves the food to a random location on the board. If the cell selected is occupied
     * by the snake's body, it will choose the cell at the snake's tail.
     */
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

/**
 * Object used to occupy cells within the board. These cells are linked to represent
 * the snake, but can also represent food or any other object.
 *
 * @param x x coordinate on the board
 * @param y y coordinate on the board
 * @param cellSize size of the cell
 * @param gap gap separating the cells
 * @param color the color of the cell
 */
function snakeCell(x, y, cellSize, gap, color) {
    this.x = x;
    this.y = y;
    this.gap = gap;
    this.element = document.createElement("div");
    this.element.style.width = cellSize - 2 * gap + "px";
    this.element.style.height = cellSize - 2 * gap + "px";
    this.element.style.background = color;
    this.element.style.position = "absolute";
    this.element.style.top = this.y * cellSize + gap + "px";
    this.element.style.left = this.x * cellSize + gap + "px";
    $("#gameboard").append(this.element);

    /**
     * Change the position of this snake cell
     *
     * @param x new x coordinate
     * @param y new y coordinate
     */
    this.changeXY = function(x, y) {
        this.x = x;
        this.y = y;
        this.element.style.top = this.gap + y * cellSize + 'px';
        this.element.style.left = this.gap + x * cellSize + 'px';
    }
}

/**
 * Object keeping track of scores for the game.
 *
 * @param snakeLength the snake length that is started with.
 */
function scoreBoard(snakeLength) {
    this.snakeLength = snakeLength;
    this.foodEaten = 0;
    this.cellsTraveled = 0;
}

console.log("we tried1");

var board = new gameBoard(20, 20, 20, "gameboard");
var direction = RIGHT;

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

/**
 * Starting point for the game.
 */
function startGame() {
    board.reset();
    var id = setInterval(frame, 100);

    /**
     * Game loop
     */
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

