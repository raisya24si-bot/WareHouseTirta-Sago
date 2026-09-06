/*
|--------------------------------------------------------------------------
| AJAX DRAFT PO CART (Stock Monitoring & Procurement)
|--------------------------------------------------------------------------
|
| Form-form draft PO (pilih supplier, tambah/hapus/ubah qty barang)
| ditandai dengan atribut data-ajax-cart di Blade-nya. Submit form-form
| ini nggak lagi bikin browser reload halaman -- cukup fetch() ke
| endpoint yang sama, terus ganti isi #critical-stock-card dan
| #draft-panel-card pakai HTML yang dikirim balik server.
|--------------------------------------------------------------------------
*/

(function () {

    function showCartToast(message, type) {

        const flash = document.querySelector('[data-ajax-cart-flash]');

        if (!flash || !message) return;

        const isError = type === 'error';

        flash.innerHTML =
            '<div class="flash-message mb-4 flex items-start gap-2 rounded-lg border px-3 py-2 text-xs ' +
            (isError
                ? 'bg-red-50 border-red-200 text-red-700'
                : 'bg-green-50 border-green-200 text-green-700') +
            '">' + message + '</div>';

        setTimeout(function () {
            flash.innerHTML = '';
        }, 3000);
    }


    function swapWorkspace(data) {

        const criticalCard = document.getElementById('critical-stock-card');
        const draftCard = document.getElementById('draft-panel-card');

        if (data.critical_stock_html && criticalCard) {
            criticalCard.innerHTML = data.critical_stock_html;
        }

        if (data.draft_panel_html && draftCard) {
            draftCard.innerHTML = data.draft_panel_html;
        }

        if (data.message) {
            showCartToast(data.message, 'success');
        }
    }


    document.addEventListener('submit', function (e) {

        const form = e.target;

        if (!form.hasAttribute('data-ajax-cart')) return;

        e.preventDefault();

        const submitter =
            e.submitter ||
            form.querySelector('button[type="submit"], input[type="submit"]');

        let originalHtml = null;

        if (submitter) {
            originalHtml = submitter.innerHTML;
            submitter.disabled = true;
            submitter.insertAdjacentHTML(
                'beforeend',
                ' <span class="btn-spinner ml-1"></span>'
            );
        }

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST', // spoofing PUT/DELETE lewat field _method di FormData
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData,
        })
            .then(async function (response) {

                let data = null;

                try {
                    data = await response.json();
                } catch (err) {
                    data = null;
                }

                if (!response.ok) {

                    const firstError =
                        data && data.errors
                            ? Object.values(data.errors)[0]
                            : null;

                    const message =
                        (data && data.message) ||
                        (firstError ? firstError[0] : null) ||
                        'Terjadi kesalahan, coba lagi.';

                    showCartToast(message, 'error');

                    if (submitter) {
                        submitter.disabled = false;
                        submitter.innerHTML = originalHtml;
                    }

                    return;
                }

                if (data) {
                    swapWorkspace(data);
                }
            })
            .catch(function () {

                showCartToast('Koneksi bermasalah, coba lagi.', 'error');

                if (submitter) {
                    submitter.disabled = false;
                    submitter.innerHTML = originalHtml;
                }
            });
    });

})();
