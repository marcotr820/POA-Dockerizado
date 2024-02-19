<div class="modal fade animado" id="modal_pdf" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl">
     <div class="modal-content">
      <div class="modal-header p-2">
         <h5 class="modal-title">Reporte PDF</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
      </div>

      <div class="modal-body p-0">
         {{-- <iframe id="iframe_pdf" width="100%" height="600px"></iframe> --}}
         <embed type="application/pdf" id="iframe_pdf" width="100%" style="height: 85vh">
      </div>

     </div>
   </div>
</div>