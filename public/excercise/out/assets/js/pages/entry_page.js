var entry_page = {
    pageData: {},

    init: function () {
        //  isGamePlayOn = false;
        this.pageData = JSON.parse(gameService.dbGet("topicPageData", "{\"showIntro\": true}"));
        this.populate();
        this.addListeners();


    },


    toggleDiv: function (objectName, classNameList) {
        var element, name, arr;
        element = document.getElementById(objectName);
        name = classNameList;
        arr = element.className.split(" ");
        if (arr.indexOf(name) == -1) {
            element.className += " " + name;
        } else {

            element.className = element.className.replace(classNameList, "");
        }
    },

    addClass: function (objectName, classNameList) {
        var element, name, arr;
        element = document.getElementById(objectName);
        name = classNameList;
        arr = element.className.split(" ");
        if (arr.indexOf(name) == -1) {
            element.className += " " + name;
        }
    },

    removeClass: function (objectName, classNameList) {
        var element, name, arr;
        element = document.getElementById(objectName);
        name = classNameList;
        arr = element.className.split(" ");
        if (!arr.indexOf(name) == -1) {
            element.className = element.className.replace(classNameList, "");
        }
    },

    populate: function () {
        this.toggleDiv('levelDropDownOptions', 'hiddenDiv');

        if (gameService.dbGet("IsSoundOn", "NULLVALUE") == "NULLVALUE") {
            gameService.dbSet("IsSoundOn", "YES");
        }


        /* START - to Initiate Grades gathering and its population into dropdown list */


        $('#AlertPopup').hide();
        $('#popupBackground').hide();
        $('#singleMainGradeDropDownOption').hide();
        /* END - to Initiate Grades gathering and its population into dropdown list */

        /* Adding Grades in drop down */
        if (dbBank.length >= 1) {
            for (var i = 0; i < dbBank.length; i++) {
                $('#levelDropDownOptions').append("<div id='eachDropDownItem" + i + "' class='mainDropDownOption' value='" + dbBank[i].Name + "'>" + $('#singleMainGradeDropDownOption').clone().show().html() + "</div>");

                //  console.log("Clickable: " + i + " ~ " + dbBank[i].Name);
                $('#eachDropDownItem' + i + '').text(dbBank[i].Name + "");
                // $('#eachDropDownItem' + i).click(function () {
                //     var xbv=  i;
                //     console.log("xbv: " + xbv);
                //     // console.log("Clicked name: " + dbBank[parseInt(i)].Name);
                //     // $('#levelSelectedText').text(""+dbBank[i].Name);
                // }) ;
            }

        } else {

            /* Show error if non */
            $('#AlertPopup').show();

            $('#popupBackground').show();

        }


        if (gameService.dbGet("IsSoundOn", "NO") == "NO") {
            gameService.stopSound("bg_sound", true);
            //  console.log("Sound Off");
            $('#soundIcon').addClass("soundOff");
            $('#soundIcon').removeClass("soundOn");
        }



        // console.log('selGrade Found');
        // if(selectedGrade>=0)
        // {
        //     console.log('selGrade Found is valid: ' + selectedGrade);

        //     $(".mainDropDownOption").click();
        //     //$('#levelSelectedText').text(dbBank[selectedGrade].Name);
        // }
        if (gameService.initParams.grade != null) {
            for (var xk = 0; xk < dbBank.length; xk++) {
                if (dbBank[xk].Name && dbBank[xk].Name == gameService.initParams.grade) {
                    $("#levelSelectedText").text(gameService.initParams.grade);
                    break;
                }
            }
        }
        if (gameService.dbGet("KP18-CLUEON-GAME_userSeletedClass") != null) {
            for (var xk = 0; xk < dbBank.length; xk++) {
                if (gameService.dbGet("KP18-CLUEON-GAME_userSeletedClass") && dbBank[xk].Name && dbBank[xk].Name == gameService.dbGet("KP18-CLUEON-GAME_userSeletedClass")) {
                    selectedGrade = getGradeIndex(gameService.dbGet("KP18-CLUEON-GAME_userSeletedClass"));
                    console.log("Class selected: " + selectedGrade);
                    //  _this.addClass('levelDropDownOptions', 'hiddenDiv');
                    $("#levelSelectedText").text(gameService.dbGet("KP18-CLUEON-GAME_userSeletedClass"));
                }
            }
        }

    },

    toggleDropDownMain: function () {
        if ($('#levelDropDownOptions').is(':hidden')) {
            $('#dropArrowComboID').removeClass('flippedY');
            animateMe('#levelDropDownOptions', 'flipInX', 200, function () { $('#levelDropDownOptions').show(); isMenuOpen = true; });
        } else {
            $('#dropArrowComboID').addClass('flippedY');
            animateMe('#levelDropDownOptions', 'fadeOutUp', 200, function () { $('#levelDropDownOptions').hide(); isMenuOpen = false; });
        }

    },

    addListeners: function () {
        //  console.log("hello js " + dbBank);
        var _this = this;


        $('#returnToHomeButton').click(function () {

            animateMe('#AlertPopup', 'zoomOut', 300, function () { $('#AlertPopup').hide(); });
            $('#popupBackground').hide();

            playSound("smallPressSound", false);
            /* $('#goButton').hide();
             $('.startLevelSelection').hide();*/
        });


        $(".startSelectionComboBoxBorder").click(function () {
            playSound("click_sound", false);
            //  _this.toggleDiv('levelDropDownOptions', 'hiddenDiv');
            entry_page.toggleDropDownMain();
        });


        $(".mainDropDownOption").click(function () {
            playSound("click_sound", false);
            gameService.dbSet("KP18-CLUEON-GAME_userSeletedClass", $(this).attr('value'));

            entry_page.toggleDropDownMain();
            selectedGrade = getGradeIndex($(this).attr('value'));
            //    console.log("Class selected: " + $(this).attr('value'));
            // _this.addClass('levelDropDownOptions', 'hiddenDiv');
            $("#levelSelectedText").text($(this).attr('value'));
        });

        $('.entryScreen').click(function (e) {
            //  console.log('Currenty Clicked: ' + this.className);
            // if(this.className. != "startSelectionComboBoxBorder") {
            if (isMenuOpen == true) {

                $('#dropArrowComboID').addClass('flippedY');
                animateMe('#levelDropDownOptions', 'flipOutX', 400, function () { $('#levelDropDownOptions').hide(); isMenuOpen = false; });

            }
            //}
        });

        $("#goButton").data(dbBank).bind('click', function () {

            if ($("#goButton").is(':disabled'))
                return;
            $("#goButton").prop('disabled', true);
            setTimeout(function () {
                $("#goButton").prop('disabled', false);
            }, 500);


            var tmpGrade = $('#levelSelectedText').text().trim();//.split(' ')[0].slice(0, $('#levelSelectedText').text().split(' ')[0].length-2);
            selectedGrade = getGradeIndex(tmpGrade);
            //alert($('#levelSelectedText').text());
            if (selectedGrade != -1 && (dbBank[selectedGrade].Name) == $('#levelSelectedText').text()) {
                playSound("goPressSound", false);
                if (dbBank[selectedGrade].Topics.length == 1) {
                    selectedTopic = 0;
                    index_page.showPage(AppSet.pages.CoreGame);
                }
                else {
                    // window.location.replace("select_level.html");
                    index_page.showPage(AppSet.pages.Topic);
                    // $(".slideLeftToRight").addClass('show');S
                }

            } else {


                var tmpGrade = $('#levelSelectedText').text().trim();//.split(' ')[0].slice(0, $('#levelSelectedText').text().split(' ')[0].length-2);
                selectedGrade = getGradeIndex(tmpGrade);

                // console.log("Grade Selected Was: " + tmpGrade);
                $('#alertTextMessage').html("Invalid Class!<BR>Please Select Again..");

                $('#AlertPopup').show(); animateMe('#AlertPopup', 'zoomIn', 300, function () { $('#AlertPopup').show(); });
                $('#popupBackground').show();
                playSound("errorPopupSound", false);
            }


        });

        $("#toggleSoundButton").click(function () {

            if ($("#toggleSoundButton").is(':disabled'))
                return;
            $("#toggleSoundButton").prop('disabled', true);
            setTimeout(function () {
                $("#toggleSoundButton").prop('disabled', false);
            }, 500);
            toggleSound();
        });

        /*
        $("#levelComboBoxCore").click(function(){
            console.log(event.target.id);
            if ((Object.is((event.target.id), 'game')) || (Object.is((event.target.id), ''))) {

                addClass('levelDropDownOptions', 'hiddenDiv');
                addClass('dropArrowComboID', 'flippedY');
            }
        });
        $("#goButton").click(function(){
            // window.location.replace("select_level.html");
            index_page.showPage(AppSet.pages.Topic);
             // $(".slideLeftToRight").addClass('show');S



        });
*/

    }
};