import Swal from "sweetalert2";
import Choices from "choices.js";
import "choices.js/public/assets/styles/choices.min.css";

window.Swal = Swal;
window.Choices = Choices;

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    showCloseButton: true,
    timer: 3500,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});

window.Toast = Toast;

window.toast = {
    success(title, text = "") {
        return Toast.fire({
            icon: "success",
            title: title,
            text: text || undefined,
            color: "#0f172a",
            iconColor: "#059669",
            background: "#ecfdf5",
            confirmButtonColor: "#059669",
        });
    },
    error(title, text = "") {
        return Toast.fire({
            icon: "error",
            title: title,
            text: text || undefined,
            color: "#0f172a",
            iconColor: "#e11d48",
            background: "#fff1f2",
            confirmButtonColor: "#e11d48",
        });
    },
    warning(title, text = "") {
        return Toast.fire({
            icon: "warning",
            title: title,
            text: text || undefined,
            color: "#0f172a",
            iconColor: "#d97706",
            background: "#fffbeb",
            confirmButtonColor: "#d97706",
        });
    },
    info(title, text = "") {
        return Toast.fire({
            icon: "info",
            title: title,
            text: text || undefined,
            color: "#0f172a",
            iconColor: "#0284c7",
            background: "#f0f9ff",
            confirmButtonColor: "#0284c7",
        });
    },
    question(title, text = "") {
        return Toast.fire({
            icon: "question",
            title: title,
            text: text || undefined,
        });
    },
};

function parseCurrencyValue(value) {
    const raw = String(value ?? "").replace(/[^\d]/g, "");
    return raw === "" ? "" : raw;
}

function formatRupiahValue(value) {
    const raw = parseCurrencyValue(value);
    if (raw === "") return "";

    return new Intl.NumberFormat("id-ID").format(Number(raw));
}

function syncCurrencyField(input) {
    const hiddenName = input.getAttribute("data-currency-target");
    if (!hiddenName) return;

    const hidden = document.querySelector(
        `input[type="hidden"][name="${hiddenName}"]`,
    );
    if (!hidden) return;

    hidden.value = parseCurrencyValue(input.value);
    input.value = hidden.value ? `Rp ${formatRupiahValue(hidden.value)}` : "";
}

function initSelectableFields() {
    const selects = document.querySelectorAll('select[data-searchable="true"]');
    selects.forEach((select) => {
        if (select.dataset.choicesInitialized === "1") return;
        select.dataset.choicesInitialized = "1";

        const hasPlaceholder = !!select.querySelector('option[value=""]');
        new Choices(select, {
            searchEnabled: true,
            searchChoices: true,
            shouldSort: false,
            itemSelectText: "",
            placeholder: hasPlaceholder,
            placeholderValue: hasPlaceholder
                ? select.getAttribute("data-placeholder") ||
                  "Cari atau pilih..."
                : null,
            allowHTML: false,
        });
    });
}

function initCurrencyFields() {
    const inputs = document.querySelectorAll("input[data-currency-target]");
    inputs.forEach((input) => {
        if (input.dataset.currencyInitialized === "1") return;
        input.dataset.currencyInitialized = "1";

        syncCurrencyField(input);

        input.addEventListener("input", () => syncCurrencyField(input));
        input.addEventListener("blur", () => {
            syncCurrencyField(input);
            if (input.value && !input.value.startsWith("Rp ")) {
                input.value = `Rp ${input.value}`;
            }
        });

        input.addEventListener("focus", () => {
            const raw = parseCurrencyValue(input.value);
            input.value = raw;
        });
    });
}

function initGlobalEnhancements() {
    initSelectableFields();
    initCurrencyFields();
}

document.addEventListener("DOMContentLoaded", initGlobalEnhancements);
