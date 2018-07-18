function onSuccess(googleUser) {
    //console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
    if (googleUser) {
        var profile = googleUser.getBasicProfile();
        /*console.log('ID: ' + profile.getId());
        console.log('Full Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        console.log('Family Name: ' + profile.getFamilyName());
        console.log('Image URL: ' + profile.getImageUrl());
        console.log('Email: ' + profile.getEmail());*/

        // post / update
        $.ajax({
            type: 'POST', //defaults to GET
            url: 'backend/actions.php?action=post_user', //defaults to window.location
            cache: false,
            //headers:{},
            dataType: 'application/json', //defaults to text/html
            data: {
                id: profile.getId(),
                name: profile.getName(),
                first_name: profile.getGivenName(),
                last_name: profile.getFamilyName(),
                image_url: profile.getImageUrl(),
                email: profile.getEmail()
            }, //Can be a Key/Value pair string or object. If it's an object, $.serialize is called to turn it into a Key/Value pair string
            complete: function (resp) {
                //console.log('HTTP RESP : ',resp);
                if (resp.status == 200) {
                    //var data = $.parseJSON(resp.responseText);
                    //window.location.href = window.location.href;
                    resp = JSON.parse(resp.responseText);

                    console.log('here...', resp);

                    if (resp.error > 0)
                        alert(resp.message);
                    else
                        init_view();
                }
                else {
                    //console.log('error resp', resp);
                }

            }
        });
    }
}

function onFailure(error) {
    console.log(error);
}

function renderButton() {
    gapi.signin2.render('g-signin2', {
        'scope': google_signin_scope,
        'width': 240,
        'height': 50,
        'longtitle': true,
        'theme': 'dark',
        'onsuccess': onSuccess,
        'onfailure': onFailure
    });
}