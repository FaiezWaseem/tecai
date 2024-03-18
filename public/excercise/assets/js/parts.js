const get = ($) => document.querySelector($);


const tabs = [ 'diagram'  , 'theme', 'backgrounds' ,'output' ] 

let nextTab = null;

let currentTab = null;

let previousTab = null;

let selectedBackground = null;
let isTheme = true;

let type  = null;

var imageBase64 = null;

let currentIndex = 0;
let previousIndex = -1;


get('#showNext').addEventListener('click', function () {

  currentTab = tabs[currentIndex];
  previousTab = tabs[currentIndex - 1];
  nextTab = (currentIndex + 1) > tabs.length ? null :  tabs[currentIndex + 1];

  if(currentTab === tabs[0]){
     if(!imageBase64){
      alert('Please Select an Image')
      return;
     }
     if(pinpoints.length == 0){
      alert('Please Add Labels ')
      return;
     }
  }

  if(currentTab === tabs[1]){
    if(!type){
      alert('Please Select A Theme')
      return;
    }
  }
  if(currentTab === tabs[2]){
    if(!selectedBackground){
      alert('Please Select A Background')
      return;
    }
  }

  if(nextTab){

    get(`#${currentTab}`).classList.toggle('active');
    get(`#${currentTab}`).classList.toggle('show');
    
    get(`#${nextTab}`).classList.toggle('active');
    get(`#${nextTab}`).classList.toggle('show');

    currentIndex = currentIndex +1;
    previousIndex = currentIndex - 1;
  }else{
    console.log("No Next Tab" , nextTab , currentIndex , previousIndex)
  }

})
get('#showPrev').addEventListener('click', function () {

  currentTab = tabs[currentIndex];
  previousTab = previousIndex == -1 ? -1 :  tabs[previousIndex];
  nextTab = (previousIndex + 1) > tabs.length ? null :  tabs[previousIndex + 1];

  if(previousIndex !== -1){

    get(`#${currentTab}`).classList.toggle('active');
    get(`#${currentTab}`).classList.toggle('show');
    
    get(`#${previousTab}`).classList.toggle('active');
    get(`#${previousTab}`).classList.toggle('show');

    currentIndex = currentIndex - 1;
    previousIndex = currentIndex - 1;

  }else{
    console.log("Cannot Go Back" ,previousIndex)
  }

})




imageEvents()
function imageEvents(){
// li click event
var liElements = document.querySelectorAll('#backgrounds li');
liElements.forEach(function (li) {
  li.addEventListener('click', function () {
    var isSelected = this.classList.contains('selected');

    // Remove 'selected' class from all li elements
    liElements.forEach(function (li) {
      li.classList.remove('selected');
    });


    // Add 'selected' class to the clicked li element if it was not already selected
    if (!isSelected) {
      this.classList.add('selected');
      document.querySelector('.select')?.classList?.add('selected');
    } else {
      document.querySelector('.select').classList.remove('selected');
    }
    counter();
    // Call the counter function
  });
});
}
// number of selected iems
function counter() {
  // Get the li element with the 'selected' class
  var selectedElement = document.querySelector('#backgrounds li.selected');
  var sendElement = document.querySelector('.send');
  selectedBackground = selectedElement.getAttribute('theme');
  if (selectedElement) {
    // Add the 'selected' class to the send element
    sendElement?.classList?.add('selected');
    sendElement?.setAttribute('data-counter', '1');
  } else {
    // Remove the 'selected' class from the send element
    sendElement?.classList?.remove('selected');
    sendElement?.setAttribute('data-counter', '0');
  }
}


ThemeEvents()
function ThemeEvents(){
  // li click event
  var liElements = document.querySelectorAll('#theme li');
  liElements.forEach(function (li) {
    li.addEventListener('click', function () {
      var isSelected = this.classList.contains('selected');
  
      // Remove 'selected' class from all li elements
      liElements.forEach(function (li) {
        li.classList.remove('selected');
      });
  
  
      // Add 'selected' class to the clicked li element if it was not already selected
      if (!isSelected) {
        this.classList.add('selected');
        document.querySelector('#theme .select')?.classList?.add('selected');
      } else {
        document.querySelector('#theme .select').classList.remove('selected');
      }
      Themecounter();
      // Call the counter function
    });
  });
  }
  // number of selected iems
  function Themecounter() {
    // Get the li element with the 'selected' class
    var selectedElement = document.querySelector('#theme li.selected');
    var sendElement = document.querySelector('#theme .send');
    type = selectedElement.getAttribute('type');
    if (selectedElement) {
      // Add the 'selected' class to the send element
      sendElement?.classList?.add('selected');
      sendElement?.setAttribute('data-counter', '1');
    } else {
      // Remove the 'selected' class from the send element
      sendElement?.classList?.remove('selected');
      sendElement?.setAttribute('data-counter', '0');
    }
  }
  



// Specific Function for this Drag and Drop
function generateDropHTML() {

  const paragraph = get('#blank_paragraph').value;
  const lines = paragraph.split(' ');
  const replacedPara = lines.map(word => blanks.includes(word) ? `<div class="drop" target="${word}"></div>` : word);
  const html = replacedPara.join(',').replaceAll(',', ' ');
  return html.toString();
}
function generateSelectionHTML() {
  const htmlStr = blanks.map(blank => `<div class="item dragdrop" sid="${blank}">${blank}</div>`)
  return (htmlStr.join(',').replaceAll(',', ' '))
}
function getThemeImage() { return selectedBackground }

async function postData() {

  const sendJSON = JSON.stringify({
    type : 'parts',
    theme : true,
    typeTheme : type,
    bg : getThemeImage(),
    dropImage : imageBase64.toString(),
    pinpoints : JSON.stringify(pinpoints)
  })
  console.log(sendJSON)
  var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  var headers = {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken
  };

  const form = new FormData();
  form.append('data', sendJSON)
  form.append('type', 'parts')
  showLoader(true)

  const req = await fetch(window.location.href, {
    method: 'POST',
    body: JSON.stringify({
      data: sendJSON,
      type: 'parts',
  }),
  headers: headers,
  })
  const res = await req.json()

  if(res.success){
   showLoader(false)
  var link = document.createElement("a"); // Or maybe get it from the current document
  link.href = '../../../teacher/assignment/view/' + res.id +"?teacher=true";
  link.target = '_blank'
  document.body.appendChild(link);
  link.click();
  } 

}



// Get the canvas element
const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');



// Store the pinpoints and their names
const pinpoints = [];


// Draw the pinpoints and their names on the canvas
function drawPinpoints() {
  context.clearRect(0, 0, canvas.width, canvas.height);
  context.drawImage(img, 0, 0, canvas.width, canvas.height);

  pinpoints.forEach(pinpoint => {
    context.beginPath();
    context.arc(pinpoint.x, pinpoint.y, 5, 0, 2 * Math.PI, false);
    context.fillStyle = 'red';
    context.fill();
    context.closePath();

    // Render the name of the pinpoint
    context.font = 'bold 16px Arial';
    context.fillStyle = 'black';
    context.fillText(pinpoint.name, pinpoint.x + 10, pinpoint.y);
  });
}

const img = new Image();

const imageInput = document.getElementById('fileToUpload');
imageInput.addEventListener('change', function (event) {
  const file = event.target.files[0];

  img.onload = function () {
    imageBase64 = img.src
    context.drawImage(img, 0, 0, canvas.width, canvas.height);
  };

  const reader = new FileReader();
  reader.onload = function (event) {
    img.src = event.target.result;
  };

  reader.readAsDataURL(file);
});


// Handle right-click event on canvas
canvas.addEventListener('click', addPinpoint);

// Get the elements for the custom dialog box
const customDialog = document.getElementById('customDialog');
const dialogInput = document.getElementById('pinpointName');
const dialogOkButton = document.getElementById('dialogOkButton');
const dialogCancelButton = document.getElementById('dialogCancelButton');

// Add event listeners to the OK and Cancel buttons
dialogOkButton.addEventListener('click', function () {
  const name = dialogInput.value;
  if (name) {
    pinpoints.push({ x: this.x, y: this.y, name });
    drawPinpoints();
  }

  // Hide the custom dialog box
  customDialog.style.display = 'none';
});

dialogCancelButton.addEventListener('click', function () {
  // Hide the custom dialog box
  customDialog.style.display = 'none';
});

function addPinpoint(event) {
  event.preventDefault();
  const rect = canvas.getBoundingClientRect();
  const x = event.clientX - rect.left;
  const y = event.clientY - rect.top;

  // Show the custom dialog box
  customDialog.style.display = 'block';

  // Clear the input field
  dialogInput.value = '';

  // Pass the x and y values to the event listener functions
  dialogOkButton.x = x;
  dialogOkButton.y = y;
}

// Handle drag-and-drop
const draggableElements = document.querySelectorAll('.name');

draggableElements.forEach(element => {
  element.addEventListener('dragstart', dragStart);
});

canvas.addEventListener('dragover', dragOver);
canvas.addEventListener('drop', drop);

let draggedElement = null;

function dragStart(event) {
  draggedElement = event.target;
  event.dataTransfer.setData('text/plain', event.target.innerText);
}

function dragOver(event) {
  event.preventDefault();
}

function drop(event) {
  event.preventDefault();
  const rect = canvas.getBoundingClientRect();
  const x = event.clientX - rect.left;
  const y = event.clientY - rect.top;

  const name = event.dataTransfer.getData('text/plain');
  const matchingPinpoint = pinpoints.find(pinpoint => pinpoint.name === name);
  if (matchingPinpoint) {
    matchingPinpoint.x = x;
    matchingPinpoint.y = y;
    drawPinpoints();
  }
}

drawDefaultText()
function drawDefaultText() {
  const defaultText = 'Please Select an Image to Create Labels of Diagram';

  const canvasWidth = canvas.width;
  const canvasHeight = canvas.height;

  context.fillStyle = 'white';
  context.font = '20px Arial';
  context.textAlign = 'center';
  context.fillText(defaultText, canvasWidth / 2, canvasHeight / 2);
}