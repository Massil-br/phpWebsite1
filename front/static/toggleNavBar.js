const hamburgerBtn = document.getElementById('hamburgerBtn');
const navLinks = document.getElementById('navlinks');

hamburgerBtn.addEventListener('click', ()=>{
    navLinks.classList.toggle('active');
});


//margin top  of main content because of the fixed navBar
const header = document.getElementById('headContainer');
const mainContent = document.getElementById('main');


if (!header) {
  console.error('Element #header introuvable');
}

if (!mainContent) {
  console.error('Element #mainContent introuvable');
}

const resizeObserver = new ResizeObserver(entries =>{
    for(const entry of entries){
        const headerHeight = entry.contentRect.height;
        if(mainContent){
            mainContent.style.marginTop = `${headerHeight + 48}px`;
        }
    }
});

resizeObserver.observe(header);