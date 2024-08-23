const loadingScreen = document.querySelector(".container");
const loadingText = document.getElementById('loading-text');

window.onload = () => {
    setTimeout(function() {
        loadingText.innerText = 'Loading.';
    }, 500);
    setTimeout(function() {
        loadingText.innerText = 'Loading..';
    }, 1000);
    setTimeout(function() {
        loadingText.innerText = 'Loading...';
    }, 1500);
    setTimeout(function() {
        loadingText.innerText = 'Loading....';
    }, 2000);
    setTimeout(function() {
        loadingText.innerText = 'Loading';
    }, 2500);
    setTimeout(function() {
        loadingText.innerText = 'Loading.';
    }, 3000);
    setTimeout(function() {
        loadingText.innerText = 'Loading..';
    }, 3500);
    setTimeout(function() {
        loadingText.innerText = 'Loading...';
    }, 4000);
    setTimeout(function() {
        loadingText.innerText = 'Loading....';
    }, 4500);
    setTimeout(function() {
        loadingText.innerText = 'Loading';
    }, 5000);
    setTimeout(function() {
        loadingScreen.style.display = 'none';
        // Redirect to login page
        window.location.href = 'choose.php';
    }, 5000);
}

function changeText() {
    // You can add more functionality here if needed
}
