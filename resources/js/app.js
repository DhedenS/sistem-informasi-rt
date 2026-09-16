import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


/*
|--------------------------------------------------------------------------
| GLOBAL MOBILE RESPONSIVE
|--------------------------------------------------------------------------
|
| File ini otomatis:
|
| 1. Mengubah semua tabel menjadi mobile card.
| 2. Mengambil nama kolom dari <th>.
| 3. Memberikan data-label ke setiap <td>.
| 4. Memperbaiki empty state.
| 5. Membuat tombol Tambah full-width di HP.
| 6. Memperbaiki header card.
|
| Jadi kita tidak perlu edit semua Blade satu per satu.
|
*/


document.addEventListener('DOMContentLoaded', () => {

    makeTablesResponsive();

    makePrimaryActionsResponsive();

    makeHeadersResponsive();

});


/*
|--------------------------------------------------------------------------
| TABLE RESPONSIVE
|--------------------------------------------------------------------------
*/

function makeTablesResponsive() {

    const tables = document.querySelectorAll('main table');


    tables.forEach((table) => {

        /*
        |--------------------------------------------------------------------------
        | CLASS TABLE
        |--------------------------------------------------------------------------
        */

        table.classList.add('responsive-table');


        /*
        |--------------------------------------------------------------------------
        | AMBIL HEADER
        |--------------------------------------------------------------------------
        */

        const headers = Array.from(
            table.querySelectorAll('thead th')
        ).map((header) => {

            return header.textContent
                .replace(/\s+/g, ' ')
                .trim();

        });


        /*
        |--------------------------------------------------------------------------
        | ROW
        |--------------------------------------------------------------------------
        */

        const rows =
            table.querySelectorAll('tbody tr');


        rows.forEach((row) => {

            const cells =
                Array.from(row.querySelectorAll('td'));


            /*
            |--------------------------------------------------------------------------
            | EMPTY STATE
            |--------------------------------------------------------------------------
            |
            | Contoh:
            |
            | <td colspan="4">
            |     Belum ada data...
            | </td>
            |
            */

            if (
                cells.length === 1 &&
                cells[0].hasAttribute('colspan')
            ) {

                row.classList.add(
                    'responsive-empty-row'
                );

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | DATA LABEL
            |--------------------------------------------------------------------------
            */

            cells.forEach((cell, index) => {

                const label =
                    headers[index] || 'Data';


                cell.setAttribute(
                    'data-label',
                    label
                );

            });

        });



        /*
        |--------------------------------------------------------------------------
        | WRAPPER
        |--------------------------------------------------------------------------
        */

        const parent =
            table.parentElement;


        if (!parent) {
            return;
        }


        /*
         * Jika table sudah punya wrapper
         */

        if (
            parent.classList.contains(
                'table-responsive-wrapper'
            )
        ) {

            return;

        }


        /*
         * Jika sebelumnya pakai overflow-x-auto,
         * jadikan wrapper responsive.
         */

        if (
            parent.classList.contains(
                'overflow-x-auto'
            )
        ) {

            parent.classList.add(
                'table-responsive-wrapper'
            );

            return;

        }


        /*
         * Kalau belum ada wrapper,
         * buat secara otomatis.
         */

        const wrapper =
            document.createElement('div');


        wrapper.className =
            'table-responsive-wrapper';


        parent.insertBefore(
            wrapper,
            table
        );


        wrapper.appendChild(
            table
        );

    });

}


/*
|--------------------------------------------------------------------------
| TOMBOL TAMBAH
|--------------------------------------------------------------------------
|
| Contoh:
|
| + Tambah Blok
| + Tambah KK
| + Tambah Kategori
| + Tambah Sumber Dana
| + Tambah Surat
|
*/

function makePrimaryActionsResponsive() {

    const links =
        document.querySelectorAll('main a');


    links.forEach((link) => {

        const text =
            link.textContent
                .replace(/\s+/g, ' ')
                .trim()
                .toLowerCase();


        if (
            text.startsWith('+ tambah') ||
            text.startsWith('tambah ')
        ) {

            link.classList.add(
                'mobile-primary-action'
            );

        }

    });

}


/*
|--------------------------------------------------------------------------
| HEADER CARD
|--------------------------------------------------------------------------
|
| Mendeteksi flex header seperti:
|
| Judul                         + Tambah
|
| Di HP otomatis jadi:
|
| Judul
| deskripsi
|
| + Tambah
|
*/

function makeHeadersResponsive() {

    const flexContainers =
        document.querySelectorAll(
            'main .flex.justify-between'
        );


    flexContainers.forEach((container) => {

        container.classList.add(
            'mobile-stack-header'
        );

    });

}