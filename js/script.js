(function () {
    "use strict";

    // Add data-validate="name|email|phone|message" to any input to enable it.
    var rules = {
        name:    { test: function (v) { return v.trim().length >= 3; },
                   msg: "Name must be at least 3 characters." },
        email:   { test: function (v) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim()); },
                   msg: "Please enter a valid email address." },
        phone:   { test: function (v) { return /^[0-9]{10}$/.test(v); },
                   msg: "Phone must be exactly 10 digits." },
        message: { test: function (v) { return v.trim().length >= 10; },
                   msg: "Message must be at least 10 characters." }
    };

    function feedbackFor(input) {
        var fb = input.parentNode.querySelector(".invalid-feedback");
        if (!fb) {
            fb = document.createElement("div");
            fb.className = "invalid-feedback";
            input.parentNode.appendChild(fb);
        }
        return fb;
    }

    function validateInput(input) {
        var rule = rules[input.dataset.validate];
        if (!rule) { return true; }

        var ok = rule.test(input.value);
        input.classList.toggle("is-valid", ok);
        input.classList.toggle("is-invalid", !ok);
        input.style.borderColor = ok ? "green" : "red";   // same effect as the lab example
        feedbackFor(input).textContent = rule.msg;
        return ok;
    }

    function clearValidation(input) {
        input.classList.remove("is-valid", "is-invalid");
        input.style.borderColor = "";
    }

    document.querySelectorAll("[data-validate]").forEach(function (input) {
        input.addEventListener("input", function () { validateInput(input); });
        input.addEventListener("blur", function () {
            if (input.value !== "") { validateInput(input); }
        });
    });

    // Block submit if any field is invalid (PHP still validates again on the server)
    document.querySelectorAll("form").forEach(function (form) {
        var fields = form.querySelectorAll("[data-validate]");
        if (!fields.length) { return; }

        form.addEventListener("submit", function (e) {
            var firstBad = null;
            fields.forEach(function (f) {
                if (!validateInput(f) && !firstBad) { firstBad = f; }
            });
            if (firstBad) {
                e.preventDefault();
                firstBad.focus();
            }
        });

        // "Clear Form" button also clears the red/green borders
        form.addEventListener("reset", function () {
            fields.forEach(clearValidation);
        });
    });

    // Usage: <th onclick="sortTable(1)">Name</th>   (n = column index)
    window.sortTable = function (n) {
        var table = document.getElementById("entriesTable");
        if (!table || !table.tBodies.length) { return; }

        var tbody = table.tBodies[0];
        // ignore the "No entries found" row (it has only one cell)
        var rows = Array.prototype.slice.call(tbody.rows).filter(function (r) {
            return r.cells.length > n;
        });
        if (rows.length < 2) { return; }

        // click once = A-Z, click again = Z-A
        var asc = !(table.dataset.sortCol === String(n) && table.dataset.sortDir === "asc");

        rows.sort(function (a, b) {
            var x = a.cells[n].textContent.trim().toLowerCase();
            var y = b.cells[n].textContent.trim().toLowerCase();
            var c = x.localeCompare(y, undefined, { numeric: true });
            return asc ? c : -c;
        });
        rows.forEach(function (r) { tbody.appendChild(r); });

        table.dataset.sortCol = n;
        table.dataset.sortDir = asc ? "asc" : "desc";

        // arrow indicators in the header
        table.querySelectorAll("thead th .sort-icon").forEach(function (icon) {
            icon.textContent = "";
        });
        var icon = table.querySelectorAll("thead th")[n].querySelector(".sort-icon");
        if (icon) { icon.textContent = asc ? " \u25B2" : " \u25BC"; }
    };

    /* ---------- 3. Row highlight on hover ---------- */
    var table = document.getElementById("entriesTable");
    if (table && table.tBodies.length) {
        Array.prototype.forEach.call(table.tBodies[0].rows, function (row) {
            row.addEventListener("mouseover", function () { row.classList.add("row-hover"); });
            row.addEventListener("mouseout",  function () { row.classList.remove("row-hover"); });
        });
    }

    /* ---------- 4. Bootstrap delete-confirmation modal ---------- */
    var deleteModal = document.getElementById("deleteModal");
    if (deleteModal) {
        deleteModal.addEventListener("show.bs.modal", function (event) {
            var btn = event.relatedTarget;           // the Delete button that was clicked
            if (!btn) { return; }
            document.getElementById("confirmDeleteBtn").href =
                "delete.php?id=" + encodeURIComponent(btn.getAttribute("data-id"));
            document.getElementById("deleteEntryName").textContent =
                btn.getAttribute("data-name") || "this entry";
        });
    }

    // Fix "aria-hidden on a focused element" warning:
    // take focus off Cancel / X / Yes buttons BEFORE Bootstrap hides the modal.
    if (deleteModal) {
        deleteModal.addEventListener("hide.bs.modal", function () {
            if (document.activeElement && deleteModal.contains(document.activeElement)) {
                document.activeElement.blur();
            }
        });
    }

    /* ---------- 5. Success alerts fade out automatically ---------- */
    document.querySelectorAll(".alert-success").forEach(function (alertBox) {
        setTimeout(function () {
            if (window.bootstrap && document.body.contains(alertBox)) {
                bootstrap.Alert.getOrCreateInstance(alertBox).close();
            }
        }, 4000);
    });
})();
