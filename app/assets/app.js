import './styles/app.scss';
import './styles/styles.css';
import AOS from 'aos';
import 'bootstrap/dist/js/bootstrap.bundle';
import 'jquery/dist/jquery';
import 'popper.js/dist/popper';
import 'bootstrap';
import 'bootstrap/js/dist/dropdown';
import 'bootstrap/js/dist/util';

AOS.init();
const $ = require('jquery');

import 'select2';
require('select2');
require('select2/dist/css/select2.css');

global.$ = global.jQuery = $

    global.refreshPage = function refreshPage() {
        window.location.reload();
    }

global.countUpdate = function(str){
    var lng=document.getElementById("custom_user_account_description").value.length;
    var lng = str.length;
    document.getElementById("charcount").innerHTML = lng + ' ';
}
//select2
$('.multiselect-select2')
    .select2({
        placeholder: 'Choisissez une langue',
        width: 'resolve',
        multiple: true,
        tags: true,
        tokenSeparators: ['/',',',';'," "],
        maximumSelectionLength: 3,
    });


// $(document).ready(function () {
//     $.ajax({
//         type: "POST",
//         url: "{{ path('user_get_profile_image') }}",
//         data: {},
//         dataType: "json",
//         success: function (response) {
//             if (response != null || response != "" || !jQuery.isEmptyObject(response)) {



//                 $('#pi').attr('src', response);

//             } else {
//                 $('#pi').attr('src', "{{ asset('build/images/profil.png') }}");


//             }
//         },
//         error: function (error) {
//             console.log(error)
//             $('#pi').attr('src', "{{ asset('build/images/profil.png') }}");


//         }
//     });
// });




import titleImage1Path from './img/6461.png';
import hikerPath from './img/8576.png';
import languagesPath from './img/10827.png';
import calenderPath from './img/calendar.png';
import chatPath from './img/chat.png';
import headerPath from './img/header-img.jpg';
import logowhitePath from './img/logo_white.png';
import profilPath from './img/profil.png';
import refreshPath from './img/refresh.png';
import talkPath from './img/talk.png';
import logoPath from './img/logo.png';
import faviconPath from './img/favicon.png';

let titleImage = `<img src="${titleImage1Path}" >`;
let hiker = `<img src="${hikerPath}" >`;
let languages = `<img src="${languagesPath}" >`;
let calender = `<img src="${calenderPath}" >`;
let chat = `<img src="${chatPath}" >`;
let header = `<img src="${headerPath}" alt="ACME logo">`;
let talk = `<img src="${talkPath}" alt="ACME logo">`;
let refresh = `<img src="${refreshPath}" alt="ACME logo">`;
let profil = `<img src="${profilPath}" alt="ACME logo">`;
let logowhite = `<img src="${logowhitePath}" alt="ACME logo">`;
let logo = `<img src="${logoPath}" alt="ACME logo">`;
let favicon = `<img src="${faviconPath}" alt="ACME logo">`;