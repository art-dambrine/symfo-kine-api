import Vue from "vue"

const showToast = function (toastType, toastMessage, toastDuration) {

  // Tire partie de vue-toast-notification (cf. documentation)

  let defaultToastDuration = 5000

  if (!isNaN(toastDuration)) {
    defaultToastDuration = toastDuration
  }

  let successToast = {
    message: toastMessage,
    type: 'success',
    duration: defaultToastDuration,
    dismissible: true,
    queue: false,
    position: 'bottom',
    onClick: this.onClick,
    onClose: this.onClose,
  }

  let errorToast = {
    message: toastMessage,
    type: 'error',
    duration: defaultToastDuration,
    dismissible: true,
    queue: false,
    position: 'bottom',
    onClick: this.onClick,
    onClose: this.onClose,
  }

  let infoToast = {
    message: toastMessage,
    type: 'info',
    duration: defaultToastDuration,
    dismissible: true,
    queue: false,
    position: 'bottom',
    onClick: this.onClick,
    onClose: this.onClose,
  }

  switch (toastType) {
    case 'success':
      Vue.$toast.open(successToast)
      break
    case 'error' :
      Vue.$toast.open(errorToast)
      break
    case 'info' :
      Vue.$toast.open(infoToast)
      break
  }
}

export default {showToast}
