<div class="float" id="notes-square" style="padding: 50px; display: none;">
  <div class="form" style="width: 100%; height: 100%;">
    <h1 class="notes-title">Notas de: <b></b></h1>
    <div class="notes-text">
      <div style="display: flex; justify-content: center;">
        <span style="margin-top: 100px; font-size: 2em; color: #aaa; user-select: none;">"No hay nada aquí"</span>
      </div>
    </div>
    <span class="close" id="closeFloatNotes">
      <img src="{{ asset('img/close.svg') }}" alt="close-icon" style="pointer-events: none; user-select: none;">
    </span>
    <script>
      document.getElementById('closeFloatNotes').addEventListener('click',(e)=>{
        e.target.parentElement.parentElement.style.display = "none";
      });
    </script>
  </div>
</div>