// @ts-nocheck
// document.addEventListener("DOMContentLoaded", function () {
//   const checkBox = document.querySelector("#client_addUser");
//   const userform = document.querySelector("#client_userId");
//   checkBox.addEventListener("change", (e) => {
//     console.log(e.target.checked);
//   });
// });
document.addEventListener("DOMContentLoaded", function () {
  const AddUser = document.querySelector("#client_addUser");
  const formClient = document.getElementsByName("client")[0];
  // On attend juste que la personne clique le champ de chekbox, et s'il check on soumet le formulaire
  AddUser.addEventListener("change", (e) => {
    // sI on envoie ici
    formClient.submit();
  });
});
