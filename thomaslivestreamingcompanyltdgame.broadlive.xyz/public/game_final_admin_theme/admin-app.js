(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('table.table').forEach(function (table) {
            var heads = Array.prototype.slice.call(table.querySelectorAll('thead th')).map(function (th) {
                return (th.textContent || '').trim();
            });

            table.querySelectorAll('tbody tr').forEach(function (row) {
                Array.prototype.slice.call(row.children).forEach(function (cell, index) {
                    if (!cell.getAttribute('data-label')) {
                        cell.setAttribute('data-label', heads[index] || '');
                    }
                });
            });
        });
    });
})();
