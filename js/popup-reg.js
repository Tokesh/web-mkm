const regPopup = document.querySelector(".popup-register");
const logPopup = document.querySelector(".popup-login");
signupBtn = document.querySelector("#signup");
mainContent = document.querySelector(".main-content");
closeRegBtn = document.querySelector("#closeRegBtn");
loginBtn = document.querySelector("#login");
closeLogBtn = document.querySelector("#closeLogBtn");

signupBtn.addEventListener("click", () => {
    regPopup.classList.add("show");
    mainContent.classList.add("show");
    regPopup.classList.remove("close");
    mainContent.classList.remove("close");
});

closeRegBtn.addEventListener("click", () => {
    regPopup.classList.add("close");
    mainContent.classList.add("close");
    regPopup.classList.remove("show");
    mainContent.classList.remove("show");
});

loginBtn.addEventListener("click", () => {
    logPopup.classList.add("show");
    mainContent.classList.add("show");
    logPopup.classList.remove("close");
    mainContent.classList.remove("close");
});

closeLogBtn.addEventListener("click", () => {
    logPopup.classList.add("close");
    mainContent.classList.add("close");
    logPopup.classList.remove("show");
    mainContent.classList.remove("show");
});

