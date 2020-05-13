//configs magnificPopup lightbox

$(document).ready(function($) {
    $('a[href*=".jpg"], a[href*=".jpeg"], a[href*=".png"], a[href*=".gif"]').each(function(){
        if ($(this).parents('.gallery').length == 0) {
            $(this).magnificPopup({
                type:'image',
                closeOnContentClick: true,
                });
            }
        });
    $('.gallery').each(function() {
        $(this).magnificPopup({
            delegate: 'a',
            type: 'image',
            gallery: {enabled: true}
            });
        });
    });


//validation of album form
$(document).ready(function () {
    $("form#form_picture").submit(function () {
        return xoopsFormValidate_form_picture();
    });
});
// validation of youtube videos
$(document).ready(function () {
    $("form#form_videos").submit(function () {

        if ($("form#form_videos input#videourl").val() === "") {
            window.alert("Please enter YouTube code");
            $("form#form_videos input#videourl").focus();
            return false;
        }
        return true;
    });
});


//validation of Notes
$(document).ready(function () {
    $("form#formNoteNew").submit(function () {
        return xoopsFormValidate_formNoteNew();
    });
});


$(document).ready(function () {
    $("div.suico-Note-details-form").hide();
});


$(document).ready(function () {
    $("a.suico-Notes-replyNote").click(function () {
        $(this).parents("div.suico-Note-details").find('div.suico-Note-details-form').slideToggle("slow");

    });
});

$(document).ready(function () {
    $("input.resetNote").click(function () {
        $(this).parents("div.suico-Note-details-form").slideToggle("slow");

    });

});

// in notes page show tips effect
$(document).ready(function () {
    $("a#show_tips").click(function () {
        $("div#xtips").slideToggle("slow");
    });
});

$(document).ready(function () {

    $("div#xtips").hide();

});

// user suspension
$(document).ready(function () {
    $("a#show_suspension").click(function () {
        $("div#suspension").slideToggle("fast");
    });
});

$(document).ready(function () {

    $("div#suspension").hide();

});


//close all search results in contributions when the page loads for the first time
$(document).ready(function () {
    $("div.suico-profile-search-module-results").slideUp("fast");
});

//open the search results for one specific module and close the others.
//If the button is clicked when the module results are open then it closes it

$(document).ready(function () {

    $("a.suico-profile-search-module-title").click(function () {
        $("div.suico-profile-search-module-results").slideUp("slow");
        if ($(this).parents("div.suico-profile-search-module").find('div.suico-profile-search-module-results').is(':hidden'))
            $(this).parents("div.suico-profile-search-module").find('div.suico-profile-search-module-results').slideDown("slow");

    });

});

$(document).ready(function () {
    $("p.odd").mouseover(function () {
        $(this).addClass("present");

    });

});

$(document).ready(function () {
    $("p.odd").mouseout(function () {
        $(this).removeClass("present");

    });

});

$(document).ready(function () {
    $("p.even").mouseover(function () {
        $(this).addClass("present");

    });

});

$(document).ready(function () {
    $("p.even").mouseout(function () {
        $(this).removeClass("present");

    });

});

$(document).ready(function () {
    $("#text").click(function () {
        $(this).html("");

    });

});

$(document).ready(function () {

    let ifChecked = "0";
    $("input#allbox").click(function () {

        if (ifChecked === "0") {
            $("input.suico-notification-checkbox").attr("checked", "checked");
            ifChecked = "1";
        } else {
            $("input.suico-notification-checkbox").attr("checked", "");
            ifChecked = "0";
        }
    });
});


function xoopsFormValidate_form_picture() {
    const myform = window.document.form_picture;
    if (myform.sel_photo.value === "") {
        window.alert("Please enter Select Photo");
        myform.sel_photo.focus();
        return false;
    }
    return true;
}


function xoopsFormValidate_formNoteNew() {
    const myform = window.document.formNoteNew;
    if (myform.text.value === "") {
        window.alert("Please enter text");
        myform.text.focus();
        return false;
    }
    return true;
}

function cleanNoteForm(id, defaultvalue) {


    const ele = xoopsGetElementById(id);
    if (ele.value === defaultvalue) {
        ele.value = "";
    }
}

function goToUserPage(id) {

    const ele = xoopsGetElementById(id);
    openWithSelfMain('index.php?uid='.ele.value);
}

function changeVisibility(id) {

    const elestyle = xoopsGetElementById(id);

    if (elestyle.style.visibility === "hidden") {
        elestyle.style.visibility = "visible";

    } else {
        elestyle.style.visibility = "hidden";
    }


}

function changeReplyVisibility(idform) {

    changeVisibility(idform);
}

function groupImgSwitch(img) {

    const elestyle = xoopsGetElementById(img).style;

    elestyle.display = "none";


}










