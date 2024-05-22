<style>
    .preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    .preview-item {
        position: relative;
        flex: 0 0 calc(33.33% - 10px);
        max-width: calc(33.33% - 10px);
    }

    .preview-item img {
        width: 100%;
        height: auto;
    }

    .delete-button {
        position: absolute;
        top: 5px;
        right: 5px;
        cursor: pointer;
        color: red;
    }
</style>
