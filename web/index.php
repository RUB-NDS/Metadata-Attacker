<!DOCTYPE html>
<html lang="en">
<head>
    <title>Metadata-Attacker</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="cache-control" content="no-cache">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="/style.css">

    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="/audio/metattacker.js"></script>
    <script src="/video/style.js"></script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="jumbotron">
            <h1>
                <span class="glyphicon glyphicon-fire"></span>
                Metadata-Attacker - XSS via Metadata
            </h1>
            <p class="text-muted">
                With this small suite of <a href="https://github.com/RUB-NDS/Metadata-Attacker" target="github">open source <i class="glyphicon glyphicon-share"></i></a> pentesting tools you're able to create an image (.jpg),
                audio (.mp3) or video (.mp4) file containing your custom metadata or a set of cross-site scripting
                vectors to test any webservice against possible XSS vulnerabilities.
            </p>
            <p class="text-muted">
                Credits and further information at <a href="https://github.com/RUB-NDS/Metadata-Attacker" target="github">the GitHub Repo</a>.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2>Select one of the available modes:</h2>
            <ul class="nav nav-tabs nav-justified">
                <li><a href="#image-attacker" data-toggle="tab"><i class="glyphicon glyphicon-camera"></i> Image-Attacker</a></li>
                <li><a href="#audio-attacker" data-toggle="tab"><i class="glyphicon glyphicon-headphones"></i> Audio-Attacker</a></li>
                <li><a href="#video-attacker" data-toggle="tab"><i class="glyphicon glyphicon-film"></i> Video-Attacker</a></li>
            </ul>
            <div class="tab-content">
                <div id="image-attacker" class="tab-pane fade">
                    <script type="text/javascript" language="javascript">
                        function check(toogle) {
                            var boxes = new Array();
                            boxes = document.getElementsByTagName('input');
                            for (var i=0; i<boxes.length; i++)  {
                                if (boxes[i].type == 'checkbox') boxes[i].checked = toogle;
                            }
                        }
                    </script>
                    <form action="/images/image.php" method="post">
                    <div class="col-md-4">
                        <div class="btn-group btn-lg">
                        <button class="btn btn-default" type="button" onclick="check(true)">Check all</button>
                        <button class="btn btn-default" type="button" onclick="check(false)">Uncheck all</button>
                        <button class="btn btn-default" type="button" onclick="document.getElementById('IPTC005').checked=true; document.getElementById('tiny-payload').value='aaa\'bbb&quot;ccc&lt;ddd'">Default Settings</button>
                        </div>
                        <br><br>
                        <p><strong>Default test string of no checkbox is selected</strong></p>
                        <input type="text" class="form-control" name="tiny-payload" id="tiny-payload" value="aaa'bbb&quot;ccc&lt;ddd"><br>
                    </div>
                    <div class="col-md-8">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">Important Information</h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    This tool allows creating an image with IPTC metadata containing testing vectors for XSS attacks via a Web interface.
                                    For each IPTC field, a checkbox can be used to include the huge collection of payloads into the selected tags (<a href="https://www.owasp.org/index.php/XSS_Filter_Evasion_Cheat_Sheet">owasp.org</a> and
                                    <a href="http://html5sec.org/">html5sec.org</a>).
                                </p>
                                <p>

                                    <strong>If a checkbox will be not selected, the string aaa'bbb"ccc&lt;ddd is automatically included into the unchecked IPTC tag.</strong>
                                    Therefore, testing for XSS vulnerabilities via IPTC metadata is possible by looking into the source code of the attacked Web application; strictly speaking for aaa'bbb"ccc&lt;ddd or alternatively by verifying if, for example, alert windows appear.
                                </p>
                            </div>

                        </div>


                        <hr>

                        <p><strong>IIM property mapping and IPTC property names</strong></p>
                        <input type="checkbox" name="IPTC004" value="1">
                        <label for="IPTC004">2#004, OBJECT_ATTRIBUTE_REFERENCE</label><br>
                        <input type="checkbox" name="IPTC005" id="IPTC005" value="1">
                        <label for="IPTC005">2#005, OBJECT_NAME</label><br>
                        <input type="checkbox" name="IPTC007" value="1">
                        <label for="IPTC007">2#007, EDIT_STATUS</label><br>
                        <input type="checkbox" name="IPTC010" value="1">
                        <label for="IPTC010">2#010, PRIORITY</label><br>
                        <input type="checkbox" name="IPTC012" value="1">
                        <label for="IPTC012">2#012, SUBJECT_REFERENCE</label><br>
                        <input type="checkbox" name="IPTC015" value="1">
                        <label for="IPTC015">2#015, CATEGORY</label><br>
                        <input type="checkbox" name="IPTC020" value="1">
                        <label for="IPTC020">2#020, SUPPLEMENTAL_CATEGORY</label><br>
                        <input type="checkbox" name="IPTC022" value="1">
                        <label for="IPTC022">2#022, FIXTURE_IDENTIFIER</label><br>
                        <input type="checkbox" name="IPTC025" value="1">
                        <label for="IPTC025">2#025, KEYWORDS</label><br>
                        <input type="checkbox" name="IPTC030" value="1">
                        <label for="IPTC030">2#030, RELEASE_DATE</label><br>
                        <input type="checkbox" name="IPTC035" value="1">
                        <label for="IPTC035">2#035, RELEASE_TIME</label><br>
                        <input type="checkbox" name="IPTC040" value="1">
                        <label for="IPTC040">2#040, SPECIAL_INSTRUCTIONS</label><br>
                        <input type="checkbox" name="IPTC045" value="1">
                        <label for="IPTC045">2#045, REFERENCE_SERVICE</label><br>
                        <input type="checkbox" name="IPTC047" value="1">
                        <label for="IPTC047">2#047, REFERENCE_DATE</label><br>
                        <input type="checkbox" name="IPTC050" value="1">
                        <label for="IPTC050">2#050, REFERENCE_NUMBER</label><br>
                        <input type="checkbox" name="IPTC055" value="1">
                        <label for="IPTC055">2#055, CREATED_DATE</label><br>
                        <input type="checkbox" name="IPTC060" value="1">
                        <label for="IPTC060">2#060, CREATED_TIME</label><br>
                        <input type="checkbox" name="IPTC065" value="1">
                        <label for="IPTC065">2#065, ORIGINATING_PROGRAM</label><br>
                        <input type="checkbox" name="IPTC070" value="1">
                        <label for="IPTC070">2#070, PROGRAM_VERSION</label><br>
                        <input type="checkbox" name="IPTC075" value="1">
                        <label for="IPTC075">2#075, OBJECT_CYCLE</label><br>
                        <input type="checkbox" name="IPTC080" value="1">
                        <label for="IPTC080">2#080, BYLINE</label><br>
                        <input type="checkbox" name="IPTC085" value="1">
                        <label for="IPTC085">2#085, BYLINE_TITLE</label><br>
                        <input type="checkbox" name="IPTC090" value="1">
                        <label for="IPTC090">2#090, CITY</label><br>
                        <input type="checkbox" name="IPTC092" value="1">
                        <label for="IPTC092">2#092, SUBLOCATION</label><br>
                        <input type="checkbox" name="IPTC095" value="1">
                        <label for="IPTC095">2#095, PROVINCE_STATE</label><br>
                        <input type="checkbox" name="IPTC100" value="1">
                        <label for="IPTC100">2#100, COUNTRY_CODE</label><br>
                        <input type="checkbox" name="IPTC101" value="1">
                        <label for="IPTC101">2#101, COUNTRY</label><br>
                        <input type="checkbox" name="IPTC103" value="1">
                        <label for="IPTC103">2#103, ORIGINAL_TRANSMISSION_REFERENCE</label><br>
                        <input type="checkbox" name="IPTC105" value="1">
                        <label for="IPTC105">2#105, HEADLINE</label><br>
                        <input type="checkbox" name="IPTC110" value="1">
                        <label for="IPTC110">2#110, CREDIT</label><br>
                        <input type="checkbox" name="IPTC115" value="1">
                        <label for="IPTC115">2#115, SOURCE</label><br>
                        <input type="checkbox" name="IPTC116" value="1">
                        <label for="IPTC116">2#116, COPYRIGHT_NOTICE</label><br>
                        <input type="checkbox" name="IPTC118" value="1">
                        <label for="IPTC118">2#118, CONTACT</label><br>
                        <input type="checkbox" name="IPTC120" value="1">
                        <label for="IPTC120">2#120, CAPTION</label><br>
                        <input type="checkbox" name="IPTC121" value="1">
                        <label for="IPTC121">2#121, LOCAL_CAPTION</label><br>
                        <input type="checkbox" name="IPTC122" value="1">
                        <label for="IPTC122">2#122, WRITER_EDITOR</label><br>
                        <br>

                        <div class="col-md-12">
                            <button class="btn btn-warning btn-lg"><span
                                    class="glyphicon glyphicon-download-alt"></span> Save
                            </button>
                        </div>
                    </div>
                    </form>

                </div>
                <div id="audio-attacker" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="collapse in" id="choosePrompt" style="padding-left:10px;">
                                    <h3>Choose a format:</h3>
                                    <h6>id3v1 is legacy. <br>id3v2 is the newer and most <br> popular metadata format.</h6>
                                </div>
                                <div class="btn-group btn-group-lg">
                                    <button class="btn btn-default" type="button" id="v1Button"><i class="glyphicon glyphicon-th-large"></i>
                                        id3v1
                                    </button>
                                    <button class="btn btn-default" type="button" id="v2Button"><i class="glyphicon glyphicon-th"></i> id3v2
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="collapse row" id="id3v1form">
                                    <div class="col-md-12">
                                        <h5>Choose the attack vectors you want to use: </h5>
                                        <div class="well">
                                            <form role="form" id="v1checkboxes">
                                                <div class="btn-group" data-toggle="buttons">
                                                    <label class="btn btn-default checkbox-inline-btn active">
                                                        <input type="checkbox" class="" value="title">Title
                                                    </label>
                                                    <label class="btn btn-default checkbox-inline-btn active">
                                                        <input type="checkbox" class="" value="artist">Artist
                                                    </label>
                                                    <label class="btn btn-default checkbox-inline-btn active">
                                                        <input type="checkbox" class="" value="album">Album
                                                    </label>
                                                    <label class="btn btn-default checkbox-inline-btn disabled" id="v1year">
                                                        <input type="checkbox" class="disabled" value="year"> Year
                                                    </label>
                                                    <label class="btn btn-default checkbox-inline-btn active">
                                                        <input type="checkbox" class="" value="comment">Comment
                                                    </label>
                                                </div>
                                            </form>

                                            <button class="btn btn-default btn-xs" type="button" id="v1checkAllButton">Check all</button>
                                            <button class="btn btn-default btn-xs" type="button" id="v1checkNoneButton">Check none</button>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h5>Enter your payload or leave empty to use the
                                            <a title="'';!--&quot;&lt;XSS&gt;=&amp;{()}" data-toggle="popover"
                                               data-content=" View html source after injecting it and look for <XSS versus &amp;lt;XSS to see if it is vulnerable">
                                                default one</a>:
                                        </h5>
                                        <div class="well">
                                            <div>
                                                <label for="v1payload">Payload:</label>
                                                <textarea class="form-control" rows="1" maxlength=30 id="v1payload"
                                                          placeholder="max 30 characters..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-warning btn-lg" id="v1_download_button" data-loading-text="Loading..."><span
                                                class="glyphicon glyphicon-download-alt" style="margin-right:5px"></span> Save
                                        </button>

                                    </div>
                                </div>


                                <div class="collapse row" id="id3v2form">
                                    <div class="col-md-12">
                                        <h5>Select the frames you want to have injected: (hold <kbd>shift</kbd> or <kbd>ctrl</kbd> to select
                                            more than one):</h5>
                                        <div class="well">
                                            <select multiple class="form-control" id="v2select">
                                                <option value="AENC">AENC: Audio Encryption Information</option>
                                                <option value="APIC">APIC: Picture w/ Description</option>
                                                <option value="COMM">COMM: Comments</option>
                                                <option value="COMR">COMR: Commercial Info</option>
                                                <option value="GRIP">COMR: Group Identification Registration</option>
                                                <option value="ENCR">ENCR: Encryption method registration</option>
                                                <option value="IPLS">IPLS: Involved People List</option>
                                                <option value="OWNE">OWNE: Ownership Info</option>
                                                <option value="POPM">POPM: Popularimeter</option>
                                                <option value="POPM">PRIV: Private Frame</option>
                                                <option value="TALB" selected="selected">TALB: Album</option>
                                                <option value="TBPM">TBPM: Beats per Minute</option>
                                                <option value="TCAT">TCAT: Podcast Category</option>
                                                <option value="TCMP">TCMP: Compilation</option>
                                                <option value="TCOM">TCOM: Composers</option>
                                                <option value="TCON">TCON: Genre</option>
                                                <option value="TCOP">TCOP: Copyright</option>
                                                <option value="TDAT">TDAT: Date of Recording</option>
                                                <option value="TDES">TDES: Podcast Description</option>
                                                <option value="TDLY">TDLY: Playlist Delay</option>
                                                <option value="TENC">TENC: Encoded By</option>
                                                <option value="TEXT">TEXT: Lyricists or Writers</option>
                                                <option value="TFLT">TFLT: Filetype</option>
                                                <option value="TGID">TGID: Podcast ID</option>
                                                <option value="TIME">TIME: Time for the Recording</option>
                                                <option value="TIT1">TIT1: Contentgroup</option>
                                                <option value="TIT2" selected="selected">TIT2: Title</option>
                                                <option value="TIT3">TIT3: Subtitle</option>
                                                <option value="TKEY">TKEY: Initialkey</option>
                                                <option value="TKWD">TKWD: Podcast Keywords</option>
                                                <option value="TLAN">TLAN: Language</option>
                                                <option value="TLEN">TLEN: Length</option>
                                                <option value="TMED">TMED: Media Type</option>
                                                <option value="TMOO">TMOO: Mood</option>
                                                <option value="TOAL">TOAL: Original Album Title</option>
                                                <option value="TOFN">TOFN: Original Filename</option>
                                                <option value="TOLY">TOLY: Original Lyricists/Text Writers</option>
                                                <option value="TOPE" selected="selected">TOPE: Original Artists/Performers</option>
                                                <option value="TORY">TORY: Original Release Year</option>
                                                <option value="TOWN">TOWN: Fileowner</option>
                                                <option value="TPE1" selected="selected">TPE1: Artists</option>
                                                <option value="TPE2">TPE2: Album Artists</option>
                                                <option value="TPE3">TPE3: Conductor</option>
                                                <option value="TPE4">TPE4: Remix Artist</option>
                                                <option value="TPOS">TPOS: Discnumber</option>
                                                <option value="TPUB">TPUB: Publisher</option>
                                                <option value="TRCK">TRCK: Track Number</option>
                                                <option value="TRDA">TRDA: Recording Dates</option>
                                                <option value="TRSN">TRSN: Internet Radio Station Name</option>
                                                <option value="TRSO">TRSO: Internet Radio Station Owner</option>
                                                <option value="TSIZ">TSIZ: Size of Audio File</option>
                                                <option value="TSRC">TSRC: International Standard Recording Code</option>
                                                <option value="TSSE">TSSE: Software and settings used for encoding</option>
                                                <option value="TYER">TYER: Year</option>
                                                <option value="UFID">UFID: Unique File Identifier</option>
                                                <option value="USER">USER: Terms of Use Framer</option>
                                                <option value="TSOT">TSOT: Sort Order of Title</option>
                                                <option value="USLT">USLT: Unsynced Lyrics</option>
                                                <option value="WFED">WFED: Podcast URL</option>
                                                <option value="WCOM">WCOM: Commercial Site</option>
                                                <option value="WCOP">WCOP: Copyright Site</option>
                                                <option value="WOAF">WOAF: Audiofile</option>
                                                <option value="WOAR">WOAR: Artist</option>
                                                <option value="WOAS">WOAS: Audiosource</option>
                                                <option value="WORS">WORS: Radiopage</option>
                                                <option value="WPAY">WPAY: Payment Site</option>
                                                <option value="WPUB">WPUB: Publisher Site</option>
                                                <option value="WXXX">WXXX: Custom URL Field</option>
                                                <option value="TXXX">TXXX: Custom Text Field</option>
                                            </select>

                                            <button class="btn btn-default btn-xs" type="button" id="v2checkAllButton">Select all</button>
                                            <button class="btn btn-default btn-xs" type="button" id="v2checkNoneButton">Select none</button>
                                        </div>

                                        <h5>Enter your payload or leave empty to use the
                                            <a href="javascript://" title="'';!--&quot;&lt;XSS&gt;=&amp;{()}" data-toggle="popover"
                                               data-content="View html source after injecting it and look for <XSS versus &amp;lt;XSS to see if it is vulnerable">
                                                default one</a>:
                                        </h5>
                                        <div class="well">
                                            <div>
                                                <label for="v2payload">Payload:</label>
                                                <textarea class="form-control" rows="5" id="v2payload"
                                                          placeholder="'';!--&quot;&lt;XSS&gt;=&amp;{()}"></textarea>
                                                <button class="btn btn-default btn-xs" id="pastePayload">click here</button>
                                                to insert a big payload collection aggregated from
                                                <a href="https://www.owasp.org/index.php/XSS_Filter_Evasion_Cheat_Sheet">owasp.org</a> and
                                                <a href="http://html5sec.org/">html5sec.org</a>, that should create an alert popup on
                                                vulnerable sites.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-warning btn-lg" id="v2_download_button" data-loading-text="Loading..."><span
                                                class="glyphicon glyphicon-download-alt" style="margin-right:5px"></span> Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div id="v1LocalFileModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Offline usage</h4>
                                </div>
                                <div class="modal-body">
                                    <p>You appear to be using this app locally, please provide the file <code>noot_no_ID3.mp3</code></p>
                                    <span class="btn btn-warning btn-file text-center">
                    <input id="v1LocalFile" accept=".mp3" type="file">Browse
                </span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div id="localtxtModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Offline usage</h4>
                                </div>
                                <div class="modal-body">
                                    <p>You appear to be using this app locally, please provide the file <code>bigPayload.txt</code> or enter
                                        the payload manually</p>
                                    <span class="btn btn-warning btn-file text-center">
                    <input id="localtxt" accept=".txt" type="file">Browse
                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="video-attacker" class="tab-pane fade">
                    <form action="/video/generate.php" method="post">
                        <input type="hidden" name="length" value="30sec" id="videoLength">
                        <div class="col-md-3">
                            <div class="collapse in" id="choosePrompt" style="padding-left:10px;">
                                <h3>Choose a length:</h3>
                                <h6>30sec is around 1MB file size.<br>5min is around 20MB file size.</h6>
                            </div>
                            <div class="btn-group btn-group-lg">
                                <button class="btn btn-default" type="button" id="30secButton"><i class="glyphicon glyphicon-resize-small"></i>
                                    30sec
                                </button>
                                <button class="btn btn-default" type="button" id="10minButton"><i class="glyphicon glyphicon-resize-full"></i> 10min
                                </button>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h5>
                                Select the fields you want to inject: (hold <kbd>shift</kbd> or <kbd>ctrl</kbd> to select
                                more than one):
                            </h5>
                            <div class="well">
                                <select multiple="" class="form-control" name="fields[]" id="videoSelectBox" required="required">
                                    <option value="artist">Artist</span></option>
                                    <option value="title">Title</option>
                                    <option value="album">Album</option>
                                    <option value="genre">Genre</option>
                                    <option value="comment">Comment</option>
                                    <option value="year">Year</option>
                                    <option value="lyrics">Lyrics</option>
                                    <option value="composer">Composer</option>
                                    <option value="copyright">Copyright</option>
                                    <option value="albumArtist">Album Artist</option>
                                    <option value="description">Description</option>
                                    <option value="longdesc">Long Description</option>
                                    <option value="storedesc">Store Description</option>
                                    <option value="TVNetwork">TV Network</option>
                                    <option value="TVShowName">TV Show Name</option>
                                    <option value="TVEpisode">TV Episode</option>
                                    <option value="category">Category</option>
                                    <option value="keyword">Keyword</option>
                                    <option value="podcastURL">Podcast URL</option>
                                    <option value="podcastGUID">Podcast GUID</option>
                                    <option value="purchaseDate">Purchase Date</option>
                                    <option value="encodingTool">Encoding Tool</option>
                                    <option value="encodedBy">Encoded by</option>
                                    <option value="apID">apID</option>
                                    <option value="xID">xID</option>

                                </select>

                                <button class="btn btn-default btn-xs" type="button" id="videoCheckAllButton">Select all</button>
                                <button class="btn btn-default btn-xs" type="button" id="videoCheckNoneButton">Select none</button>
                            </div>
                            <h5>Enter your payload or leave empty to use the
                                <a href="javascript://" title="" data-toggle="popover" data-content="View html source after injecting it and look for <XSS versus &amp;lt;XSS to see if it is vulnerable" data-original-title="'';!--&quot;<XSS>=&amp;{()}">
                                    default one</a>:
                            </h5>
                            <div class="well">
                                <div>
                                    <label for="videoPayload">Payload:</label>
                                    <textarea class="form-control" rows="5" id="videoPayload" name="videoPayload" placeholder="'';!--&quot;<XSS>=&amp;{()}"></textarea>
                                    <button type="button" class="btn btn-default btn-xs" id="videoPastePayload">click here</button>
                                    to insert a big payload collection aggregated from
                                    <a href="https://www.owasp.org/index.php/XSS_Filter_Evasion_Cheat_Sheet" target="owasp">owasp.org</a> and
                                    <a href="http://html5sec.org/" target="html5sec">html5sec.org</a>, that should create an alert popup on
                                    vulnerable sites.
                                </div>
                            </div>
                            <button class="btn btn-warning btn-lg" data-loading-text="Loading...">
                                <span class="glyphicon glyphicon-download-alt"></span> Save
                            </button>
                        </div>
                    </form>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
    </div>
</div>


<nav class="navbar navbar-default navbar-fixed-bottom">
    <div class="container">
        <a class="navbar-brand" href="/">Metadata-Attacker | Ruhr-University Bochum | A MIT licensed open source pentesting tool for testing webservices against XSS vulnerabilities</a>
    </div>
</nav>


</body>
  </div></html>