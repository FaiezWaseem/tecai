const get = ($) => document.querySelector($);
let index = 0;
const out = get('.out_blanks_words');
const select_blank = get('#select_blank');
let currentTab = 'profile-tab';
let previousTab = null;


let questions = [];
let selectedBackground = null;
let isTheme = true;


get('#addLink').addEventListener('click', function () {
  isTheme = false;
  selectedBackground = get('#link').value;
  get('#theme_links').insertAdjacentHTML('afterbegin', `<li theme="theme1.jpg" class="selected" ><img src="${selectedBackground}" /></li>`)
})



get('#addQuestion').addEventListener('click', function () {
  const question = get('#question').value;
  if (question.length === 0) {
    alert('Please enter Question')
    return;
  };
  const option1 = get('#radiobutton1');
  const option2 = get('#radiobutton2');
  console.log({ question, answer: option1.checked ?? option2.checked })
  questions.push({ category: 'history', question, answer: option1.checked ?? option2.checked })
  question.value = '';
  updateQuestions()
  question = ''
})

// get('#btnsearch').addEventListener('click', async function () {
//   const search = get('#searchImage').value;
//   const jsonImages = await getSearch(encodeURIComponent(search))
//   console.log(jsonImages)
//   jsonImages.shift();
//   const container = get('#searchresults');
//   container.innerHTML = ''
//   for (let i = 0; i < jsonImages.length; i++) {
//     const element = jsonImages[i];
//     container.innerHTML += `<li theme="${element}"><img src="${element}" /></li>`
//   }
//   container.innerHTML += `
//    <li theme="theme1.jpg"><img src="../../assets/images/themes/theme1.jpg" /></li>
//    <li theme="theme2.png"><img src="../../assets/images/themes/theme2.png" /></li>
//    <li theme="theme3.jpg"><img src="../../assets/images/themes/theme3.jpg" /></li>
//    <li theme="theme4.jpg"><img src="../../assets/images/themes/theme4.jpg" /></li>
//    <li theme="theme5.jpg"><img src="../../assets/images/themes/theme5.jpg" /></li>
//    <li theme="theme6.jpg"><img src="../../assets/images/themes/theme6.jpg" /></li>
//    <li theme="theme7.jpg"><img src="../../assets/images/themes/theme7.jpg" /></li>
//    `;
//   imageEvents()

// })

function updateQuestions() {
  const Qconatiner = get('#questions');
  Qconatiner.innerHTML = '';
  questions.forEach((question, index) => {
    Qconatiner.innerHTML += `
        <div class="bg-white p-2 border-radius-10 mt-1" >
        <p>${question.question}</p>
        <span>Answer : ${question.answer} <button class="btn btn-danger" onclick='removeQuestion(${index})'>Remove <i class="fa-solid fa-delete-left"></i></button> </span>
    </div>
        `
  })
}

function removeQuestion(_index) {
  questions = questions.filter((value, index) => {
    if (index !== _index) {
      return value
    }
  })
  updateQuestions()
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
    type: 'truefalse',
    theme: true,
    bg: getThemeImage(),
    questions: JSON.stringify(questions)
  })
  console.log(sendJSON)

  var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  var headers = {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': csrfToken
  };


  const form = new FormData();
  form.append('data', sendJSON)
  form.append('type', 'truefalse')
   showLoader()
  const req = await fetch(window.location.href, {
    method: 'POST',
    body: JSON.stringify({
      data : sendJSON,
      type : 'truefalse',
    }),
    headers: headers,
  })
  const res = await req.json()

  if (res.success) {
    // showToast('created new Excercise', 'bg-success')
    showLoader(false)
    var link = document.createElement("a"); // Or maybe get it from the current document
    link.href = '../../../teacher/assignment/view/' + res.id +"?teacher=true";
    link.target = '_blank'
    document.body.appendChild(link);
    link.click();
  } 
}


async function getSearch(q) {
  const req = await fetch('../../assets/php/utils/googleImages.php?q=' + q)
  const json = await req.json()
  return json;
}