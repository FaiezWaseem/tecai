const get = ($) => document.querySelector($);

let currentTab = 'theme-tab';
let previousTab = null;

let selectedBackground = null;
let isTheme = true;

let type  = null;


imageEvents()
function imageEvents(){
// li click event
var liElements = document.querySelectorAll('#home li');
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
  var selectedElement = document.querySelector('#home li.selected');
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


 


function getThemeImage() { return selectedBackground }
const getImage = () => document.querySelector('#selectedImage').src;

async function postData() {

  const form = new FormData();
  form.append('type', 'quiz')
  form.append('theme', true)
  form.append('bg', getThemeImage())
  form.append('playImage', getImage().split("/").pop())

  const req = await fetch('../../assets/php/create.php', {
    method: 'POST',
    body: form,
  })
  const res = await req.blob()
  console.log(res)

  var link = document.createElement("a"); // Or maybe get it from the current document
  link.href = URL.createObjectURL(res);
  link.download = "quiz.zip";
  document.body.appendChild(link);
  link.click();

  get('#contact').innerHTML = `
  <iframe src="../../out/index.html"  frameborder="0"></iframe>
  <button  class="btn btn-primary" onclick="postData()">Download Again</button>
  <a  class="btn btn-primary" href="../../out/index.html">Open in full screen</a>
  `;
}