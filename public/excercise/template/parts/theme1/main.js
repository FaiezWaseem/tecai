let points = 0;
let total = -1;
let counter = 0;

function updateGrades(){
    let total = pinpoints.length;
    
    if(total === counter){
        gradeAssignment(points,total)
        .then(res => {
            if(res){
                if(res.success){
                    alert("You Are Graded")
                }
            }
        })
    }else{
        counter = counter + 1;
    }
}

// Get the canvas element
const canvas = document.getElementById("canvas");
const context = canvas.getContext("2d");

// Load the image
const image = new Image();
image.src = "./skeleton.png";
image.onload = function () {
    // Draw the image on the canvas
    context.drawImage(image, 0, 0, canvas.width, canvas.height);
    drawPinpoints();
};

// Store the pinpoints and their names
const pinpoints = [{ "x": 317, "y": 42, "name": "skull" }, { "x": 304, "y": 73, "name": "mandilla" }, { "x": 147, "y": 73, "name": "clavical" }, { "x": 118, "y": 89, "name": "scapulla" }, { "x": 146, "y": 125, "name": "humerus" }, { "x": 379, "y": 107, "name": "Thorax" }, { "x": 87, "y": 158, "name": "Ullna" }, { "x": 353, "y": 130, "name": "sternum" }, { "x": 357, "y": 164, "name": "spine" }, { "x": 378, "y": 180, "name": "pelvis" }, { "x": 334, "y": 249, "name": "Femur" }, { "x": 325, "y": 282, "name": "Patella" }, { "x": 336, "y": 311, "name": "Tibia" }, { "x": 322, "y": 325, "name": "Fibulla" }]
const dropped = [];
pinpoints.forEach(point => {
    document.getElementById("names").innerHTML += `<div class="name" draggable="true">${point.name}</div>`
})
// Store the color for highlighting the correct answer
const highlightColor = "green";

// Draw the pinpoints on the canvas
function drawPinpoints() {
    context.clearRect(0, 0, canvas.width, canvas.height);
    context.drawImage(image, 0, 0, canvas.width, canvas.height);

    pinpoints.forEach(pinpoint => {
        context.beginPath();
        context.arc(pinpoint.x, pinpoint.y, 5, 0, 2 * Math.PI, false);
        context.fillStyle = "red";
        context.fill();
        context.closePath();
    });
}

// Handle drag-and-drop
const draggableElements = document.querySelectorAll(".name");

draggableElements.forEach(element => {
    element.addEventListener("dragstart", dragStart);
});

canvas.addEventListener("dragover", dragOver);
canvas.addEventListener("drop", drop);

let draggedElement = null;

function dragStart(event) {
    draggedElement = event.target;
    event.dataTransfer.setData("text/plain", event.target.innerText);
}

function dragOver(event) {
    event.preventDefault();
}

function drop(event) {
    event.preventDefault();
    const rect = canvas.getBoundingClientRect();
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;

    const name = event.dataTransfer.getData("text/plain");
    const matchingPinpoint = pinpoints.find(pinpoint => pinpoint.name === name);
    if (matchingPinpoint) {
        console.log(matchingPinpoint, { x, y })
        if (matchingPinpoint.name === name && x >= matchingPinpoint.x - 15 && x <= matchingPinpoint.x + 15 && y >= matchingPinpoint.y - 15 && y <= matchingPinpoint.y + 15) {
            matchingPinpoint.showName = true;
            drawPinpoints();


            dropped.push(matchingPinpoint.name)
            document.getElementById("names").innerHTML = '';
            pinpoints.forEach(point => {
                if (!dropped.includes(point.name)) {
                    document.getElementById("names").innerHTML += `<div class="name" draggable="true">${point.name}</div>`
                }
            })
            const draggableElements = document.querySelectorAll(".name");

            draggableElements.forEach(element => {
                element.addEventListener("dragstart", dragStart);
            });
            console.log(event)
            points += 1;
            document.getElementById('score').innerHTML = `Score : ${points}/${pinpoints.length}`;
        } else {
            console.log({
                points,
                matchingPinpoint
            })
            matchingPinpoint.showName = true;
            matchingPinpoint.error = true;
            drawPinpoints();
            dropped.push(matchingPinpoint.name)
            document.getElementById("names").innerHTML = "";
            pinpoints.forEach(point => {
                if (!dropped.includes(point.name)) {
                    document.getElementById("names").innerHTML += `<div class="name" draggable="true">${point.name}</div>`
                }
            })
            const draggableElements = document.querySelectorAll(".name");

            draggableElements.forEach(element => {
                element.addEventListener("dragstart", dragStart);
            });
            
            alert("Wrong answer!");
        }
    }
}

// Render the names on the pinpoints
function renderNames() {
    pinpoints.forEach(pinpoint => {
        if (pinpoint.showName) {
            const name = pinpoint.name;
            const textWidth = context.measureText(name).width;
            const textHeight = 14; // Adjust the height of the background box as needed
            const boxPadding = 4; // Adjust the padding around the text as needed
            const boxX = pinpoint.x + 10;
            const boxY = pinpoint.y - 10 - textHeight;
            const boxWidth = textWidth + 2 * boxPadding;
            const boxHeight = textHeight + 4;

            // Draw the background box
            context.fillStyle = pinpoint?.error ? "red" : "green"; // Adjust the color and opacity as needed
            context.fillRect(boxX, boxY, boxWidth, boxHeight);

            // Draw the text
            context.font = "bold 16px Arial"; // Set the font weight to bold
            context.fillStyle = "white";
            context.fillText(name, boxX + boxPadding, boxY + boxHeight - boxPadding);
        }
    });
}

canvas.addEventListener("mousemove", function () {
    context.clearRect(0, 0, canvas.width, canvas.height);
    context.drawImage(image, 0, 0, canvas.width, canvas.height);
    drawPinpoints()
    renderNames();
});


