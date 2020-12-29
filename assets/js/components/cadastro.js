const inputElement = document.getElementById('image');
inputElement.addEventListener('change', handleFiles, false);

function handleFiles() {
  const fileList = this.files; /* now you can work with the file list */
  console.log(fileList);
  const img = document.getElementById('imm');
  img.src = URL.createObjectURL(this.files[0]);
  img.onload = function () {
    URL.revokeObjectURL(this.src);
  };
}
