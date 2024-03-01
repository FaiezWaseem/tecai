
const get = ($) => document.querySelector($);

const modalFooter = get('.modal-footer')
const modaltitle = get('.modal-title')
const modalBody = get('.modal-body')


const modal = get('#modal')
if (modal) {
    modal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        const option = button.getAttribute('option')

        modaltitle.textContent = `Create New ${option}`

        createActivity(option)

    })
}


function createActivity(option) {
    switch (option) {
        case 'blanks':
            console.log('blanks')
            blanks()
            break;
        default:
            console.log('default')
            break;
    }
}

function blanks() {

    let blanks = [];
    const out = get('.out_blanks_words');
    const select_blank = get('#select_blank');
    select_blank.addEventListener('click', GetSelectedText)


    function GetSelectedText() {
        if (window.getSelection) {  // all browsers, except IE before version 9
            var range = window.getSelection();
            blanks.push(range.toString().trim())
            out.innerHTML += `<b>${range.toString()}</b> `
        }
        else {
            if (document.selection.createRange) { // Internet Explorer
                var range = document.selection.createRange();
                // alert(range.text);
                blanks.push(range.toString().trim())
                out.innerHTML += `<b>${range.toString()}</b> `
            }
        }
    }

    get('#next').addEventListener('click' , function(){
        const paragraph =  get('#blank_paragraph').value;
        const lines =  paragraph.split(' ');
        const replacedPara = lines.map(word => blanks.includes(word) ? `<div style="width:40px;height:40px;background: red;" drop-word="${word}" > </div>` : word);
         console.log(replacedPara.join(','))
    })
}