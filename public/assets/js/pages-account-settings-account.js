/**
 * Account Settings - Account
 */

'use strict';

// Adding Upload Image
document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    const deactivateAcc = document.querySelector('#formAccountDeactivation');

    // Update/reset user image of account page
    let accountUserImage = document.getElementById('uploadedAvatar');
    const fileInput = document.querySelector('.account-file-input'),
      resetFileInput = document.querySelector('.account-image-reset');

    if (accountUserImage) {
      const resetImage = accountUserImage.src;
      fileInput.onchange = () => {
        if (fileInput.files[0]) {
          accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
        }
      };
      resetFileInput.onclick = () => {
        fileInput.value = '';
        accountUserImage.src = resetImage;
      };
    }
  })();
});

// Editing Upload Image

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    const deactivateAcc = document.querySelector('#formAccountDeactivation');

    // Update/reset user image of account page
    let edit_accountUserImage = document.getElementById('edit-uploadedAvatar');
    // const edit_new = document.getElementById('edit-new_img');
    const edit_fileInput = document.querySelector('.edit-account-file-input'),
    edit_resetFileInput = document.querySelector('.edit-account-image-reset');

    if (edit_accountUserImage) {
      const edit_resetImage = edit_accountUserImage.src;
      edit_fileInput.onchange = () => {
        if (edit_fileInput.files[0]) {
           edit_accountUserImage.src = window.URL.createObjectURL(edit_fileInput.files[0]);
           document.getElementById('edit-new_img').value = '1';
        }
      };
      edit_resetFileInput.onclick = () => {
       edit_fileInput.value = '';
       edit_accountUserImage.src = edit_resetImage;
       document.getElementById('edit-new_img').value = '2';
      };
      
    }
  })();
});


