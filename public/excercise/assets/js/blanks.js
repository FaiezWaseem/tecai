String.prototype.replaceAllTxt = function replaceAll(search, replace) { return this.split(search).join(replace); }
const get = ($) => document.querySelector($);
let index = 0;
const out = get('.out_blanks_words');
const select_blank = get('#select_blank');
let currentTab = 'content';
let previousTab = null;


let blanks = [];
let selectedBackground = null;
let isTheme = true;


get('#addLink').addEventListener('click', function () {
  isTheme = false;
  selectedBackground = get('#link').value;
  get('#theme_links').insertAdjacentHTML('afterbegin', `<li theme="${selectedBackground}" class="selected" ><img src="${selectedBackground}" /></li>`)
  imageEvents()
})



get('#showNext').addEventListener('click', function () {
  if (currentTab == 'content') {
    const paragraph = get('#blank_paragraph').value;

    if (paragraph.length == 0) {
      showToast('Please Enter a Paragraph', 'bg-danger')
      return;
    }

    if (blanks.length == 0) {
      showToast('Please Select Some Blanks', 'bg-danger')
      return;
    }

    if (paragraph.length > 300) {
      showToast('Paragraph Cannot Be More the 300 Characters, Currently : ' + paragraph.length, 'bg-danger')
      return;
    }

    currentTab = 'background';
    previousTab = 'content';

    get('#content').classList.toggle('active');
    get('#content').classList.toggle('show');

    get('#background').classList.toggle('active');
    get('#background').classList.toggle('show');

  }
  else if (currentTab == 'background') {
    if (!selectedBackground) {
      showToast('Please Select A Backgroud Image', 'bg-danger');
      return;
    }

    currentTab = 'output';
    previousTab = 'background';

    get('#background').classList.toggle('active');
    get('#background').classList.toggle('show');

    get('#output').classList.toggle('active');
    get('#output').classList.toggle('show');

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


select_blank.addEventListener('click', GetSelectedText)
function GetSelectedText() {

  const paragraph = get('#blank_paragraph').value;

  if (paragraph.length == 0) {
    showToast('Please Enter a Paragraph First', 'bg-danger')
    return;
  }
  if (paragraph.length > 300) {
    showToast('Paragraph Cannot Be More the 300 Characters, Currently : ' + paragraph.length, 'bg-danger')
    return;
  }

  if (window.getSelection) {
    var range = window.getSelection();
    if (range.toString().length == 0) {
      showToast('Please Select a Word First', 'bg-danger');
      return;
    }
    if (range.toString().length > 15) {
      showToast('Blank character Length should be equals to or less than 15', 'bg-danger');
      return;
    }
    index++;
    blanks.push(range.toString().trim())
    out.innerHTML += `<b>${range.toString()} <i class="fa-solid fa-trash-can delete" onclick='removeSelection(${index})'></i></b>`
  }
  else {
    if (document.selection.createRange) {
      var range = document.selection.createRange();
      if (range.toString().length == 0) {
        showToast('Please Select a Word First', 'bg-danger');
        return;
      }
      if (range.toString().length > 15) {
        showToast('Blank character Length should be equals to or less than 15', 'bg-danger');
        return;
      }
      blanks.push(range.toString().trim())
      out.innerHTML += `<b>${range.toString()} <i class="fa-solid fa-trash-can delete" onclick='removeSelection(${index})' ></i> </b> `
    }
  }
}





function removeSelection(_ind) {
  blanks = blanks.filter((item, i) => {
    if (i !== _ind) {
      return item;
    }
  })
  out.innerHTML = ''
  for (let i = 0; i < blanks.length; i++) {
    const element = blanks[i];
    out.innerHTML += ` <b> ${element} <i class="fa-solid fa-trash-can delete" onclick='removeSelection(${i})'></i> </b> `
  }
  index = blanks.length - 1
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
        document.querySelector('.select')?.classList?.remove('selected');
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
  console.log(selectedElement)
  selectedBackground = selectedElement?.getAttribute('theme');
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

  if (paragraph.length > 300) {
    showToast('Paragraph Cannot Be More the 300 Characters, Currently : ' + paragraph.length, 'bg-danger')
    return;
  }

  let str = paragraph;
  const words = blanks;

  for (var i = 0; i < words.length; i++) {
    const word = words[i];
    const replaceStr = `<div class="drop" target="${word}"></div>`;
    const regex = new RegExp(`\\b${word}\\b`);
    str = str.replace(regex, replaceStr);
  }

  console.log(str)
  return str;

}
function generateSelectionHTML() {
  const htmlStr = blanks.map(blank => `<div class="item dragdrop" sid="${blank}">${blank}</div>`)
  return (htmlStr.join(',').replaceAllTxt(',', ' '))
}
function getThemeImage() { return selectedBackground }

async function postData() {

  const sendJSON = JSON.stringify({
    type: 'blanks',
    theme: true,
    bg: getThemeImage(),
    drop: generateSelectionHTML(),
    drag: generateDropHTML(),
  })
  console.log(sendJSON)

  var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  var headers = {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': csrfToken
  };

  const form = new FormData();
  form.append('data', sendJSON)
  form.append('type', 'blanks')
  showLoader()
  const req = await fetch(window.location.href, {
    method: 'POST',
    body: JSON.stringify({
      data: sendJSON,
      type: 'blanks',
    }),
    headers: headers,
  })
  const res = await req.json()

  if (res.success) {
    showToast('created to new Excercise', 'bg-success')

    console.log(res)

    showLoader(false)
    var link = document.createElement("a"); // Or maybe get it from the current document
    link.href = '../../../teacher/assignment/view/' + res.id +"?teacher=true";
    link.target = '_blank'
    document.body.appendChild(link);
    link.click();

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


