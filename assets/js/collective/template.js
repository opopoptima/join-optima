import dayjs from "dayjs";

const getStackIcon = (icon, transform) => `
  <span class="fa-stack ms-n1 me-3">
    <i class="fas fa-circle fa-stack-2x text-200"></i>
    <i class="${icon} fa-stack-1x text-primary" data-fa-transform=${transform}></i>
  </span>
`;

const getTemplate = event => `
<div class="modal-header bg-light ps-card pe-5 border-bottom-0">
  <div>
    <h5 class="modal-title mb-0">Collective interview ${event.title}</h5>
  </div>
  <button type="button" class="btn-close position-absolute end-0 top-0 mt-3 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-card pb-card pt-1 fs--1">
    <div class="d-flex mt-3">
    ${getStackIcon('fas fa-calendar-check')}
    <div class="flex-1">
        <h6>Date</h6>
        <p class="mb-1">
        ${dayjs && dayjs(event.start).format('dddd, MMMM D, YYYY, h:mm A')} 
          <b>-</b>
        ${dayjs && dayjs(event.end).format('dddd, MMMM D, YYYY, h:mm A')}
        
        </p>
    </div>
    </div>
    <div class="d-flex mt-3">
    ${getStackIcon('fas fa-map-marker-alt')}
    <div class="flex-1">
        <h6>Localisation</h6>
        <p class="mb-1">
        ${event.extendedProps.place}
        </p>
    </div>
    </div>
    <div class="d-flex mt-3">
    ${getStackIcon('fas fa-users')}
    <div class="flex-1">
        <h6>Recruteurs</h6>
        <p class="mb-1">
         ${event.extendedProps.recruiters}
        </p>
    </div>
    </div>
    <div class="d-flex mt-3">
    ${getStackIcon('fas fa-users')}
    <div class="flex-1">
        <h6>Candidats</h6>
        <p class="mb-1">
         ${event.extendedProps.candidates}
        </p>
    </div>
    </div>
  </div>
  </div>
</div>
<div class="modal-footer d-flex justify-content-end bg-light px-card border-top-0">



${
    (event.extendedProps.emailSent !== 1)
        ? `
<form action="/admin/remove/collective" method="post" class="collectiveInterviewRemove">
<input type="hidden" value="${event.id}" name="id">
  <button type="submit" class="btn btn-falcon-danger btn-sm">
    <span class="far fa-trash-alt fs--2 mr-2"></span>
     Remove
  </button>
 </form>
 <form action="/admin/send/email/collective" method="post" class="collectiveInterviewSendEmail">
<input type="hidden" value="${event.id}" name="id">
  <button type="submit" class="btn btn-falcon-info btn-sm">
    <span class="far fa-envelope fs--2 mr-2"></span> Send Email
  </button>
 </form>
  ` : ''
}

${
    (event.extendedProps.emailSent === 1 && !event.extendedProps.passed)
        ? `
<form action="/admin/remove/collective" method="post" class="collectiveInterviewRemove">
<input type="hidden" value="${event.id}" name="id">
  <button type="submit" class="btn btn-falcon-danger btn-sm">
    <span class="far fa-trash-alt fs--2 mr-2"></span>
     Annuler
  </button>
 </form>
  ` : ''
}

</div>
`;

export default getTemplate;
