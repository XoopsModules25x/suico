<{include file="db:suico_navbar.tpl"}>

<style>
    /* Ensure all cards have the same height */
    .gallery .card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    /* Card body should grow to fill space */
    .card-body {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    /* Create 16:9 aspect ratio for images */
    .card-img-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
        height: 0;
        overflow: hidden;
        background-color: #f8f9fa; /* Light gray background for placeholder */
    }
    
    .card-img-container img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    /* Style for the quick action buttons */
    .card-actions {
        margin-top: auto;
        padding-top: 15px;
    }
    
    .suico-album-formquick {
        display: inline-block;
        margin-right: 8px;
    }
    
    .suico-album-formquick input[type="image"] {
        width: 24px;
        height: 24px;
    }
    
    /* Private photo indicator */
    .private-indicator {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: rgba(0,0,0,0.7);
        color: white;
        padding: 3px 8px;
        border-radius: 3px;
        font-size: 12px;
        z-index: 10;
    }
    
    /* Responsive adjustments */
    @media (max-width: 575.98px) {
        .gallery .col-12 {
            padding-left: 5px;
            padding-right: 5px;
        }
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div id="content" class="content content-full-width">
                        <!-- start -->

                        <{if ($showForm|default:0 ==1) }>
                            <div class="alert alert-primary">
                                <h5>
                                    <{$lang_formtitle}>
                                </h5>

                                <form name="form_picture" id="form_picture" action="submitImage.php" method="post" enctype="multipart/form-data">
                                    <{$token}>
                                    <div class="form-group">
                                        <label for="album"><{$lang_youcanupload}><br><{$lang_countPicture}> <{$lang_max_countPicture}></label>
                                    </div>

                                    <div class="form-group">
                                        <label for="selectphoto"><strong><{$lang_selectphoto}> :</strong></label>
                                        <input type='hidden' name='MAX_FILE_SIZE' value='<{$maxfilebytes}>'>
                                        <input type='file' name='sel_photo' id="sel_photo" class='form-control-file'>
                                        <input type='hidden' name='xoops_upload_file[]' id='xoops_upload_file[]' value='sel_photo'>
                                    </div>

                                    <div class="form-group">
                                        <label><strong><{$lang_phototitle}> :</strong></label>
                                        <input type='text' class='form-control' name='title' id='title' size='35' maxlength='55' value='' required>
                                    </div>

                                    <div class="form-group">
                                        <label><strong><{$lang_caption}> :</strong></label>
                                        <textarea class="form-control" name="caption" id="caption" rows="5" cols="50" maxlength="55" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <input type='submit' class='formButton btn btn-primary' name='submit_button' id='submit_button' value='<{$lang_uploadpicture}>'>
                                    </div>
                                </form>
                            </div>
                        <{/if}>

                        <h5 class="mb-4">
                            <{$lang_photos}>
                        </h5>
                        <{if $lang_nopicyet|default:'' =="" }>
                            <div class="row gallery">
                                <{section name=i loop=$pics_array}>
                                    <div class="col-12 col-sm-6 col-lg-4 mb-4">
                                        <div class="card h-100">
                                            <div class="card-img-container">
                                                <{if ($pics_array[i].private == 1)}>
                                                    <span class="private-indicator">
                                                        <span class='fa fa-lock'></span> <{$lang_privatephoto}>
                                                    </span>
                                                <{/if}>
                                                <a name="<{$pics_array[i].image_id}>" href="<{$xoops_url}>/uploads/suico/images/resized_<{$pics_array[i].filename}>" rel="lightbox[album]" title="<{$pics_array[i].title}> - <{$pics_array[i].caption}>">
                                                    <img class="card-img-top" src="<{$xoops_url}>/uploads/suico/images/<{$pics_array[i].filename}>" alt="<{$pics_array[i].title}>">
                                                </a>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title"><{$pics_array[i].title}></h5>
                                                <p class="card-text"><{$pics_array[i].caption}></p>
                                                <p class="text-muted small">
                                                    <span class='fa fa-calendar'></span>
                                                    <{if $pics_array[i].date_created == $pics_array[i].date_updated}>
                                                        <{$pics_array[i].date_created|date_format}>
                                                    <{else}>
                                                        <{$pics_array[i].date_updated|date_format}>
                                                    <{/if}>
                                                </p>
                                                
                                                <{if (($isOwner==1))}>
                                                    <div class="card-actions">
                                                        <form action="delpicture.php" method="post" id="deleteform" class="suico-album-formquick">
                                                            <input type="hidden" value="<{$pics_array[i].image_id}>" name="image_id">
                                                            <{$token}>
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="<{$lang_delete}>">
                                                                <span class='fa fa-trash'></span>
                                                            </button>
                                                        </form>
                                                        <form action="editpicture.php" method="post" id="editform" class="suico-album-formquick">
                                                            <input type="hidden" value="<{$pics_array[i].image_id}>" name="image_id">
                                                            <{$token}>
                                                            <button type="submit" class="btn btn-sm btn-outline-primary" title="<{$lang_editpicture}>">
                                                                <span class='fa fa-edit'></span>
                                                            </button>
                                                        </form>
                                                        <form action="avatar.php" method="post" id="setavatar" class="suico-album-formquick">
                                                            <input type="hidden" value="<{$pics_array[i].image_id}>" name="image_id">
                                                            <{$token}>
                                                            <button type="submit" class="btn btn-sm btn-outline-success" title="<{$lang_avatarchange}>">
                                                                <span class='fa fa-user-circle'></span>
                                                            </button>
                                                        </form>
                                                        <form action="private.php" method="post" id="setprivate" class="suico-album-formquick">
                                                            <input type="hidden" value="<{$pics_array[i].image_id}>" name="image_id">
                                                            <{$token}>
                                                            <{if $pics_array[i].private == 1}>
                                                                <input type="hidden" value="0" name="private">
                                                                <button type="submit" class="btn btn-sm btn-outline-warning" title="<{$lang_unsetprivate}>">
                                                                    <span class='fa fa-unlock'></span>
                                                                </button>
                                                            <{else}>
                                                                <input type="hidden" value="1" name="private">
                                                                <button type="submit" class="btn btn-sm btn-outline-warning" title="<{$lang_setprivate}>">
                                                                    <span class='fa fa-lock'></span>
                                                                </button>
                                                            <{/if}>
                                                        </form>
                                                    </div>
                                                <{/if}>
                                            </div>
                                        </div>
                                    </div>
                                <{/section}>
                            </div>
                        <{else}>
                            <div class="alert alert-primary"><{$lang_nopicyet}></div>
                        <{/if}>

                        <{if $navegacao!='' }>
                            <div class="mt-4">
                                <{$navegacao}>
                            </div>
                        <{/if}>

                        <{include file="db:suico_footer.tpl"}>

                        <!-- end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>