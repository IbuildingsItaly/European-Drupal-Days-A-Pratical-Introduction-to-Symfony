$(document).ready(function () {
    $("#more").click(function () {
        load_users($(this));
    });
});

function load_users(btn) {

    if (!btn.is("[load]")) {

        $.ajax({
            type: "GET",
            url: Routing.generate('load_user_ajax', {'total_users': $('ul#users_list li').length}),
            dataType: "json",
            beforeSend: function () {
                btn.attr('load', true); //Add an Attribute to avoid multiple calls
                btn.html('Loading...');
            },
            success: function (msg) {
                console.dir(msg);
                if (msg.status === "OK") {
                    $($.parseHTML(msg.template)).appendTo('ul#users_list');
                    if(!msg.show_btn){
                        $("#more").remove();
                    }
                } else {
                    console.log("KO");
                    alert("Error !");
                }
            },
            error: function (msg) {
            },
            complete: function (msg) {
                btn.removeAttr('load');
                btn.html('Load User');
            }
        });
    }
}