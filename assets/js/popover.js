/* -------------------------------------------------------------------------- */
/*                                   Popover                                  */
/* -------------------------------------------------------------------------- */

const popoverInit = () => {
  const popoverTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="popover"]')
  );
  popoverTriggerList.map(popoverTriggerEl => {
    return new Popover(popoverTriggerEl);
  });
};

export default popoverInit;
