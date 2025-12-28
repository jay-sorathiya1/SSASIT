export function remove_Url_Parameter(parameter) {
            // Create a URL object from the current URL
            const url = new URL(window.location.href);

            // Use the searchParams API to delete the specified parameter
            url.searchParams.delete(parameter);

            // Update the URL in the browser without reloading the page
            window.history.replaceState({}, '', url.toString());
        }