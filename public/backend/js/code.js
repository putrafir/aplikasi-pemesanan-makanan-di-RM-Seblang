$(function () {
    $(document).on("click", "#delete", function (e) {
        e.preventDefault();
        var link = $(this).attr("href");

        Swal.fire({
            title: "Are you sure?",
            text: "Delete This Data?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
                Swal.fire("Deleted!", "Your file has been deleted.", "success");
            }
        });
    });
});

$(function () {
    $(document).on("click", ".btn-stok", function (e) {
        e.preventDefault();
        let form = $(this).closest("form");

        Swal.fire({
            title: "Apakah Anda Yakin?",
            text: "Ingin Mengubah Stok?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Ubah!",
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
                Swal.fire("Berhasil!", "Stok telah diubah.", "success");
            }
        });
    });
});
$(function () {
    $(document).on("click", "#btn-status", function (e) {
        e.preventDefault();
        let form = $(this).closest("form");

        Swal.fire({
            title: "Apakah Anda Yakin?",
            text: "Ingin Mengubah Status?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Ubah!",
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
                Swal.fire("Berhasil!", "Status telah diubah.", "success");
            }
        });
    });
});
