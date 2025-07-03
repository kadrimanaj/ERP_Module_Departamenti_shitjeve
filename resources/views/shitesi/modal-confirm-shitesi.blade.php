  
  <style>
    .sweetalert-style {
        border-radius: 1rem;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        padding: 1.5rem;
    }

    .sweetalert-style .modal-title {
        font-size: 1.4rem;
        font-weight: 600;
    }

    .sweetalert-style .modal-body {
        font-size: 1.1rem;
    }

    .sweetalert-style .btn {
        border-radius: 2rem;
    }
  </style>

<div class="modal fade" id="confirmProjectModal" tabindex="-1" aria-labelledby="confirmProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content sweetalert-style text-center">
        <div class="modal-header border-0 justify-content-center">
          <h5 class="modal-title" id="confirmProjectModalLabel">
            <i class="ri-error-warning-fill text-warning me-2" style="font-size: 40px;"></i> Confirm Project
          </h5>
        </div>
        <div class="modal-body">
          <p class="fs-5 mb-1">Are you sure you want to confirm this project?</p>
        </div>
        <div class="modal-footer border-0 justify-content-center">
            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
            <form id="confirmProjectForm" action="{{ route('project.shitesi.confirm', ['id' => '__ID__']) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success px-4">Yes, Confirm</button>
            </form>
        </div>
      </div>
    </div>
</div>