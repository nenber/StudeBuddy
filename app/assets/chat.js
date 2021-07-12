// let chatDiv = document.querySelector('.test');
// chatDiv.scrollTop = chatDiv.scrollHeight; // On souhaite scroller toujours jusqu'au dernier message du chat
// let form = document.getElementById('form');
// function handleForm(event) {
//     //  event.preventDefault(); // Empêche la page de se rafraîchir après le submit du formulaire
// }
// form.addEventListener('submit', handleForm);
//
// const submit = document.getElementById('btnEnvoi');
// submit.onclick = e => { // On change le comportement du submit
//     console.log("fefefef")
//     const message = document.getElementById('message'); // Récupération du message dans l'input correspondant
//     const data = { // La variable data sera envoyée au controller
//         'content': message.value, // On transmet le message...
//         'channel': {{ channel.id }} // ... Et le canal correspondant
// }
//     console.log(data); // Pour vérifier vos informations
//     console.log("clique ici !!")
//     fetch('/message', { // On envoie avec un post nos datas sur le endpoint /message de notre application
//         method: 'POST',
//         body: JSON.stringify(data) // On envoie les data sous format JSON
//     }).then((response) => {
//         message.value = '';
//         console.log(response);
//         window.location.reload();
//     });
// }