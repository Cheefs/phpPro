window.addEventListener('load', () => {
   const $table = document.querySelector('.table');

   if ($table) {
       $table.addEventListener('click', (e) => {
           const $target = e.target;
           if ($target.parentElement.classList.contains('table__row')) {
               if ($target.classList.contains('actions') ) {
                   location.href = $target.dataset.href;
               } else {
                   location.href = $target.parentElement.dataset.href;
               }
           } else if ($target.classList.contains('btn')) {
               location.href = $target.dataset.href;
           }
       });
   }

   const $content = document.querySelector('.content');
   if ($content) {
       $content.addEventListener('click', (e) => {
           const target = e.target;
           const classList = target.classList;
           if (classList.contains('redirect')) {
               location.href = target.dataset.href;
           } else if (target.tagName.toLowerCase() === 'input') {
               classList.remove('has_error')
           }
       });
   }

   if (location.href.match('users') || location.href.match('admin') ) {
       const $elements = document.querySelectorAll('.nav__element ');

       if ($elements) {
           const $title = document.querySelector('.action-name');
           const action = $title? $title.textContent.trim(): null;
           for (let i = 0; i< $elements.length; i++) {
               if ($elements[i].textContent.trim() === action ){
                   $elements[i].classList.add('active');
                   break;
               }
           }
       }

   }
});
