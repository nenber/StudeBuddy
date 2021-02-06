import './styles/app.scss';
import './styles/styles.css';
// import 'aos/dist/aos';
import "jquery/dist/jquery";
import  'popper.js/dist/popper';
import 'select2';
import 'bootstrap';
import 'bootstrap/js/dist/dropdown';

// AOS.init();

function refreshPage() {
    window.location.reload();
}

$(document).ready(function () {
    $.ajax({
        type: "POST",
        url: "{{ path('user_get_profile_image') }}",
        data: {},
        dataType: "json",
        success: function (response) {
            if (response != null || response != "" || !jQuery.isEmptyObject(response)) {

                $('#pi').attr('src', response);

            } else {
                $('#pi').attr('src', "{{ asset('build/images/profil.png') }}");


            }
        },
        error: function (error) {
            console.log(error)
            $('#pi').attr('src', "{{ asset('build/images/profil.png') }}");


        }
    });
});




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