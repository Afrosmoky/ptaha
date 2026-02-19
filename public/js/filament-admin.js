window.deleteMedia = function (mediaId) {
    if (!confirm('Usunąć to zdjęcie?')) return;

    fetch(`/media/${mediaId}`, {
        method: 'DELETE',
        credentials: 'same-origin'
    }).then(() => {
        //window.location.reload();
    });
};
