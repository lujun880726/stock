<!-- CSS for slidesjs.com example -->
<link rel="stylesheet" href="/Slides/css/example.css">
<link rel="stylesheet" href="/Slides/css/font-awesome.min.css">
<!-- End CSS for slidesjs.com example -->

<!-- SlidesJS Optional: If you'd like to use this design -->
<style>

    #slides {
        display: none
    }

    #slides .slidesjs-navigation {
        margin-top:0px;
    }

    #slides .slidesjs-previous {
        margin-right: 5px;
        float: left;
    }

    #slides .slidesjs-next {
        margin-right: 5px;
        float: left;
    }

    .slidesjs-pagination {
        margin: 5px 1px 4px;
        float: right;
        list-style: none;
    }

    .slidesjs-pagination li {
        float: left;
        margin: 0 1px;
    }

    .slidesjs-pagination li a {
        display: block;
        width: 13px;
        height: 0;
        padding-top: 13px;
        background-image: url(/Slides/img/pagination.png);
        background-position: 0 0;
        float: left;
        overflow: hidden;
    }

    .slidesjs-pagination li a.active,
    .slidesjs-pagination li a:hover.active {
        background-position: 0 -13px
    }

    .slidesjs-pagination li a:hover {
        background-position: 0 -26px
    }

    #slides a:link,
    #slides a:visited {
        color: #333
    }

    #slides a:hover,
    #slides a:active {
        color: #9e2020
    }

    .navbar {
        overflow: hidden
    }
</style>

<!-- SlidesJS Required: These styles are required if you'd like a responsive slideshow -->
<style>
    #slides {
        display: none
    }

    .container {
        margin: 0 auto
    }

    /* For tablets & smart phones */
    @media (max-width: 767px) {
        body {
            padding-left: 20px;
            padding-right: 20px;
        }
        .container {
            width: auto
        }
    }

    /* For smartphones */
    @media (max-width: 480px) {
        .container {
            width: auto
        }
    }

    /* For smaller displays like laptops */
    @media (min-width: 768px) and (max-width: 979px) {
        .container {
            width: 724px
        }
    }

    /* For larger displays */
    @media (min-width: 800px) {
        .container {
            width: 1113px
        }
    }
</style>


<div id="centers">
    <div class="container" style="">
        <div id="slides">
            <img src="/Slides/img/example-slide-1.jpg" alt="Photo by: Missy S Link: http://www.flickr.com/photos/listenmissy/5087404401/">
            <img src="/Slides/img/example-slide-2.jpg" alt="Photo by: Daniel Parks Link: http://www.flickr.com/photos/parksdh/5227623068/">
            <img src="/Slides/img/example-slide-3.jpg" alt="Photo by: Mike Ranweiler Link: http://www.flickr.com/photos/27874907@N04/4833059991/">
            <img src="/Slides/img/example-slide-4.jpg" alt="Photo by: Stuart SeegerLink: http://www.flickr.com/photos/stuseeger/97577796/">
        </div>
    </div>
    <div class="">
        <div class="c_left">
            <div style="padding:5px 0 5px 8px">
                行业动态
                <span style="float: right;"><a href="/news/index.html" style="text-align:right;">更多</a></span>
            </div>
            <?php
            if ($listNews) {
                foreach ($listNews as $valN) {
                    echo "  <p><a href='/news/view/" . $valN['id'] . ".html'>" . sysSubStr($valN['title'], 80) . "...</a> <span style='float: right; padding:0 7px;'>" . date('m-d', $valN['ctime']) . "</span></p>";
                }
            } else {
                echo "<p>还没有数据</p>";
            }
            ?>
        </div>
        <div class="c_right">
            <div style="padding:5px 0 5px 8px">
                招贤纳士
                <span style="float: right;"><a href="/job/index.html" style="text-align:right;">更多</a></span>
            </div>
            <?php
            if ($listJob) {
                foreach ($listJob as $valJ) {
                    echo "  <p><a href='/job/view/" . $valJ['id'] . ".html'>{$valJ['title']}</a> <span style='float: right; padding:0 7px;'>" . date('m-d', $valJ['ctime']) . "</span></p>";
                }
            } else {
                echo '<p>还没有数据</p>';
            }
            ?>
        </div>

    </div>
    <div class="clear">&nbsp;</div>
</div>

<script src="/Slides/js/jquery.slides.min.js"></script>
<script>
    $(function() {
        $('#slides').slidesjs({
            width: 1113,
            height: 250,
            navigation: false,
            play: {
                active: false,
                // [boolean] Generate the play and stop buttons.
                // You cannot use your own buttons. Sorry.
                effect: "slide",
                // [string] Can be either "slide" or "fade".
                interval: 3000,
                // [number] Time spent on each slide in milliseconds.
                auto: true,
                // [boolean] Start playing the slideshow on load.
                swap: false,
                // [boolean] show/hide stop and play buttons
                pauseOnHover: false,
                // [boolean] pause a playing slideshow on hover
                restartDelay: 2500
                        // [number] restart delay on inactive slideshow
            }
        });
    });
</script>