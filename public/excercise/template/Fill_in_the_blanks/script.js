var score = 0;
var total = ($('.selection')[0].children.length);
$('#score').text(`SCORE : ${score}/${total}`);
$(function () {
    $('.dragdrop').draggable({
        revert: true,
        placeholder: true,
        droptarget: '.drop',
        drop: function (evt, droptarget) {
            var drag_id = $(this)[0].getAttribute("sid")
            var drop_id = droptarget.getAttribute('target')
            var dragtarget = $(this)
            ondropTarget(drag_id, drop_id, dragtarget, droptarget)
            console.log({ drag_id, drop_id, dragtarget, droptarget })
        }
    });
});

function ondropTarget(drag_id, drop_id, dragtarget, droptarget) {

    if (drag_id == drop_id) {
        score = score + 1;
        $('#score').text(`SCORE : ${score}/${total}`);
        dragtarget.appendTo(droptarget).draggable('destroy')
        droptarget.style.background = 'teal'
        // The rest of your code
    } else {
        // The rest of your code
        droptarget.style.background = 'red'
        dragtarget.appendTo(droptarget).draggable('destroy')
        console.log("wrong");
    }
    if ($('.selection')[0].children.length == 0) {
        console.log('GAME OVER')
        console.log(score, total)
        gradeAssignment(score, total)
            .then(res => {
                if(res.status){
                    alert('You are graded')
                }
            })
            .catch(err => alert(err))
    }
}
