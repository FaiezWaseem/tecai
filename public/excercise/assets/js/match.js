String.prototype.replaceAllTxt = function replaceAll(search, replace) { return this.split(search).join(replace); }
const get = ($) => document.querySelector($);

const columnLeftNamesInSequence = [],
  columnRightNamesInSequence = [];
let selectedBackground = null;
let isTheme = true;


let currentTab = 'content';
let previousTab = null;

get('#addLink').addEventListener('click', function () {
  isTheme = false;
  selectedBackground = get('#link').value;
  get('#theme_links').insertAdjacentHTML('afterbegin', `<li theme="theme1.jpg" class="selected" ><img src="${selectedBackground}" /></li>`)
  imageEvents()
})

get('#showNext').addEventListener('click', function () {


  if(currentTab === 'content'){
    
    if(columnLeftNamesInSequence.length == 0){
      showToast('Please Add The Match The Columns', 'bg-danger')
      return;
    }

    currentTab = 'background';
    previousTab = 'content';

    get('#content').classList.toggle('active');
    get('#content').classList.toggle('show');

    get('#background').classList.toggle('active');
    get('#background').classList.toggle('show');

  }else if(currentTab === 'background'){

    if(!selectedBackground){
      showToast('Please Select A Background', 'bg-danger')
      return;
    }

    currentTab = 'output';
    previousTab = 'background';

    get('#background').classList.toggle('active');
    get('#background').classList.toggle('show');

    get('#output').classList.toggle('active');
    get('#output').classList.toggle('show');
  }else if(currentTab === 'output'){

  }

})
get('#showPrev').addEventListener('click', function () {
  console.log({ previousTab, currentTab })
  if (currentTab == 'output') {
    let temp_oldPreviousTab = previousTab;
    get(`#${temp_oldPreviousTab}`).classList.toggle('active');
    get(`#${temp_oldPreviousTab}`).classList.toggle('show');

    get(`#${currentTab}`).classList.toggle('active');
    get(`#${currentTab}`).classList.toggle('show');

    currentTab = previousTab;
    previousTab = 'content'
  } else if (currentTab == 'background') {

    let temp_oldPreviousTab = previousTab;
    get(`#${temp_oldPreviousTab}`).classList.toggle('active');
    get(`#${temp_oldPreviousTab}`).classList.toggle('show');

    get(`#${currentTab}`).classList.toggle('active');
    get(`#${currentTab}`).classList.toggle('show');

    currentTab = previousTab;
    previousTab = null

  }



})


get('#addColumn').addEventListener('click', function () {
  let leftValue = get("#columnleft");
  let rightValue = get("#columnright");

  columnLeftNamesInSequence.push(leftValue.value)
  columnRightNamesInSequence.push(rightValue.value)

  console.log(leftValue, rightValue)
  leftValue.value = ''
  rightValue.value = ''
  renderColumns()
})


function renderColumns() {
  const container = get('.output');
  container.innerHTML = ''
  for (let i = 0; i < columnLeftNamesInSequence.length; i++) {
    const leftValue = columnLeftNamesInSequence[i];
    const rightValue = columnRightNamesInSequence[i];

    container.innerHTML += `
        <tr>
          <th scope="row">${leftValue}</th>
          <td>${rightValue}</td>
       </tr>      
      `

  }
}
imageEvents()
function imageEvents() {
  // li click event
  var liElements = document.querySelectorAll('#background li');
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
  var selectedElement = document.querySelector('#background li.selected');
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

async function postData() {

  const sendJSON = JSON.stringify({
    type: 'match',
    theme: true,
    bg: getThemeImage(),
    columnleft: JSON.stringify(columnLeftNamesInSequence),
    columnright: JSON.stringify(columnRightNamesInSequence),
  })
  console.log(sendJSON)
  var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  var headers = {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': csrfToken
  };

  const form = new FormData();
  form.append('data', sendJSON)
  form.append('type', 'match')
  showLoader()
  const req = await fetch(window.location.href, {
    method: 'POST',
    body: JSON.stringify({
      data : sendJSON,
      type : 'match',
    }),
    headers: headers,
  })
  const res = await req.json()

  if (res.success) {
    showToast('created new Excercise', 'bg-success')
    showLoader(false)
    var link = document.createElement("a"); // Or maybe get it from the current document
    link.href = '../../../teacher/assignment/view/' + res.id +"?teacher=true";
    link.target = '_blank'
    document.body.appendChild(link);
    link.click();
  }else{
    showLoader(false)
  }
}


function showToast(message, color) {
  const toastElement = document.getElementById('toast');
  const toastBodyElement = toastElement.querySelector('.toast-body');

  // Update the toast message
  toastBodyElement.innerText = message;

  // Change the toast color
  toastElement.classList.remove('bg-primary', 'bg-secondary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info');
  toastElement.classList.add(color);

  // Show the toast
  const toast = new bootstrap.Toast(toastElement);
  toast.show();

  // Hide the toast after 3 seconds
  setTimeout(function () {
    toast.hide();
  }, 5000);
}

