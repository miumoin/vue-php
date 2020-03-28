function set_storage_data(key, value){
    if (typeof(Storage) !== "undefined") {
    localStorage.setItem(key, value);
    return true;
    } else {
    alert("Sorry, your browser does not support Web Storage...");
    }
    return false;
} 
function get_storage_data(key){
    if (typeof(Storage) !== "undefined") {
    if(localStorage.getItem(key) != null){
        return localStorage.getItem(key);
    }
    return '';
    } else {
    alert("Sorry, your browser does not support Web Storage...");
    }
    return false;
}
function delete_storage_data(key){
    if (typeof(Storage) !== "undefined") {
    if(localStorage.getItem(key) != null){
        localStorage.removeItem(key);
    }
    return true;
    } else {
    alert("Sorry, your browser does not support Web Storage...");
    }
    return false;
}
function set_page_meta( meta ) {
    if( meta.title != undefined ) document.title = meta.title;
    if( meta.metaTags != undefined ) {
        const metas = document.getElementsByTagName('meta');
        for( var i = 0; i < meta.metaTags.length; i++ ) {
            var match_found = false;
            for (var j = 0; j < metas.length; j++) {
                if( ( meta.metaTags[i]['name'] != undefined && metas[j].getAttribute('name') === meta.metaTags[i]['name'] ) || ( meta.metaTags[i]['property'] != undefined && metas[j].getAttribute('property') === meta.metaTags[i]['property'] ) ) {
                    metas[j].setAttribute( 'content', meta.metaTags[i]['content'] );
                    match_found = true;
                    break;
                }
            }
            if( !match_found ) {
                var metaElement = document.createElement('meta');
                if( meta.metaTags[i]['property'] != undefined ) metaElement.setAttribute( 'property', meta.metaTags[i]['property'] );
                if( meta.metaTags[i]['name'] != undefined ) metaElement.setAttribute( 'name', meta.metaTags[i]['name'] );
                if( meta.metaTags[i]['content'] != undefined ) metaElement.setAttribute( 'content', meta.metaTags[i]['content'] );
                document.head.appendChild(metaElement);
            }
        }
    }
}
function db_time_to_only_date(datetime){
    var t = datetime.split('T');
    return t[0];
}
function valid_email(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
function slugify (title) {
    var slug = "";
    // Change to lower case
    var titleLower = title.toLowerCase();
    // Letter "e"
    slug = titleLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e');
    // Letter "a"
    slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a');
    // Letter "o"
    slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o');
    // Letter "u"
    slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u');
    // Letter "d"
    slug = slug.replace(/đ/gi, 'd');
    // Trim the last whitespace
    //slug = slug.replace(/\s*$/g, '');
    // Change whitespace to "-"
    slug = slug.replace(/\s+/g, '-');
    
    return slug;
}
//Google login scripts
function googleLoginSuccess(element) {
    console.log(element.id);
    auth2.attachClickHandler(element, {},
    function(googleUser) {
        axios.post(App.base + '/api/authenticate', { params: { type: 'google', id_token: googleUser.getAuthResponse().id_token } }, { headers: { 'X-Vuedoo-Domain': App.domain, 'X-Vuedoo-Access-Key' : '' } }).then(response => {
            log_me_in(response.data);
        })
        .catch((error) => {
            console.log(error);
        });
    }, function(error) {
        //console.log(JSON.stringify(error, undefined, 2));
    });
}
function googleLoginFailure() {
    return true;
}

function facebookLoginstatusChangeCallback( fblogin ) {
    if (fblogin.status === 'connected') {
        axios.post(App.base + '/api/authenticate', { params: { type: 'facebook', access_token: fblogin.authResponse.accessToken, userId: fblogin.authResponse.userId } }, { headers: { 'X-Vuedoo-Domain': App.domain, 'X-Vuedoo-Access-Key' : '' } }).then(response => {
            log_me_in(response.data);
        })
        .catch((error) => {
            console.log(error);
        });
    } else {
      //console.log( 'Please log ' + 'into this webpage.' );
    }
}

function log_me_in( response ) {
    if( response.params.access_key != undefined ) {
        set_storage_data('access_key', response.params.access_key);
        set_storage_data('name', response.params.name);
        window.location.href = App.base;
    }
}

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,    
    function(m,key,value) {
      vars[key] = value;
    });
    return vars;
}

function isPasswordValid( password ) {
    var lowerCaseLetters = /[a-z]/g;
    var upperCaseLetters = /[A-Z]/g;
    var numbers = /[0-9]/g;
    if( ( password.match(lowerCaseLetters) || password.match(upperCaseLetters) ) && password.match(numbers) && password.length > 5 ) {  
        return true;
    } else return false;
}


/*
        //Post method
        axios.post(App.domain + '/api/', { params: { name: 'moin', email: 'pay2moin@gmail.com' } }, { headers: { 'X-Vuedoo-Domain': App.domain, 'X-Vuedoo-Access-Key' : '123456' } }).then(response => {
            // If request is good...
            console.log(response.data);
          })
          .catch((error) => {
            console.log('error 3 ' + error);
          });

        //Get method
        axios.get(App.domain + '/api/', { headers: { 'X-Vuedoo-Domain': App.domain, 'X-Vuedoo-Access-Key' : '123456' } }).then(response => {
            // If request is good...
            console.log(response.data);
          })
          .catch((error) => {
            console.log('error 3 ' + error);
          });

        //Delete method
        axios.delete(App.domain + '/api/', { headers: { 'X-Vuedoo-Domain': App.domain, 'X-Vuedoo-Access-Key' : '123456' } }).then(response => {
            // If request is good...
            console.log(response.data);
          })
          .catch((error) => {
            console.log('error 3 ' + error);
          });

        //Put method
        axios.put(App.domain + '/api/', { params: { name: 'moin', email: 'pay2moin@gmail.com' } }, { headers: { 'X-Vuedoo-Domain': App.domain, 'X-Vuedoo-Access-Key' : '123456' } }).then(response => {
            // If request is good...
            console.log(response.data);
          })
          .catch((error) => {
            console.log('error 3 ' + error);
          });
*/
