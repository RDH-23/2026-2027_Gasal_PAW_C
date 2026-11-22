document.addEventListener("DOMContentLoaded", () => {
    // Dropdown menu Data Master
    const dropdownBtn = document.querySelector(".dropdown-btn");
    const dropdownContent = document.querySelector(".dropdown-content");

    if (dropdownBtn && dropdownContent) {
        dropdownBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            dropdownContent.classList.toggle("show");
        });

        document.addEventListener("click", () => {
            dropdownContent.classList.remove("show");
        });
    }

    // Konfirmasi aksi hapus & logout
    document.querySelectorAll("[data-confirm]").forEach((el) => {
        el.addEventListener("click", (e) => {
            if (!confirm(el.getAttribute("data-confirm"))) {
                e.preventDefault();
            }
        });
    });

    // Hitung estimasi total pada halaman Transaksi
    const selectBarang = document.getElementById("selectBarang");
    const inputQty = document.getElementById("inputQty");
    const estimasiTotal = document.getElementById("estimasiTotal");

    if (selectBarang && inputQty && estimasiTotal) {
        const hitungTotal = () => {
            const selectedOption = selectBarang.options[selectBarang.selectedIndex];
            const harga = parseInt(selectedOption.getAttribute("data-harga") || "0", 10);
            const qty = parseInt(inputQty.value || "0", 10);
            const total = harga * (qty > 0 ? qty : 0);
            estimasiTotal.value = "Rp " + total.toLocaleString("id-ID");
        };

        selectBarang.addEventListener("change", hitungTotal);
        inputQty.addEventListener("input", hitungTotal);
    }
});