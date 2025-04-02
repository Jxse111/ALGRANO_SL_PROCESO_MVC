windows.addEventListener("DOMContentLoaded", () => {
    mostrarLoader();
});

windows.addEventListener("load", () => {
    setTimeout(() => {
        esconderLoader();
    }, 2000);
});

const loader = document.getElementById("loaderPagina");

const mostrarLoader = () => {
    loader.classList.add("mostrar_loader");
};

const esconderLoader = () => {
    loader.classList.remove("mostrar_loader");
};
