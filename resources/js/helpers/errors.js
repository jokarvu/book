export default {
    error (errors) {
        if (errors.response.data.errors) {
            var messages = errors.response.data.errors;
            for (const key in messages) {
                if (messages.hasOwnProperty(key)) {
                    const tmp = messages[key];
                    tmp.forEach(element => {
                        toastr.error(element);
                    });
                }
            }
        } else {
            toastr.error(errors.response.data.message);
        }
    }
}