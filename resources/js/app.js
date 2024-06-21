import "./bootstrap";

// CKEditor 5
import { ClassicEditor as ClassicEditorBase } from "@ckeditor/ckeditor5-editor-classic";
import { Essentials } from "@ckeditor/ckeditor5-essentials";
import { Autoformat } from "@ckeditor/ckeditor5-autoformat";
import { Bold, Italic, Code } from "@ckeditor/ckeditor5-basic-styles";
import { BlockQuote } from "@ckeditor/ckeditor5-block-quote";
import { Heading } from "@ckeditor/ckeditor5-heading";
import { Link } from "@ckeditor/ckeditor5-link";
import { List } from "@ckeditor/ckeditor5-list";
import { Paragraph } from "@ckeditor/ckeditor5-paragraph";
import { SimpleUploadAdapter } from "@ckeditor/ckeditor5-upload";
import { Font, FontSize } from "@ckeditor/ckeditor5-font";
import { Alignment } from "@ckeditor/ckeditor5-alignment";
import { Table, TableToolbar, TableCellProperties, TableProperties } from "@ckeditor/ckeditor5-table";
import { Image, ImageUpload, ImageToolbar, ImageCaption, ImageStyle, ImageResizeEditing, ImageResizeHandles } from "@ckeditor/ckeditor5-image";

export default class ClassicEditor extends ClassicEditorBase {}

ClassicEditor.builtinPlugins = [
    Essentials,
    Autoformat,
    Bold,
    Italic,
    BlockQuote,
    Heading,
    Link,
    List,
    Paragraph,
    Image,
    ImageUpload,
    SimpleUploadAdapter,
    Code,
    Font,
    FontSize,
    Alignment,
    Table,
    TableToolbar,
    TableCellProperties,
    TableProperties,
    ImageToolbar,
    ImageCaption,
    ImageStyle,
    ImageResizeEditing,
    ImageResizeHandles,
];

ClassicEditor.defaultConfig = {
    toolbar: {
        items: [
            "heading",
            "|",
            "bold",
            "italic",
            "fontFamily",
            "fontSize",
            "alignment",
            "|",
            "link",
            "code",
            "|",
            "bulletedList",
            "numberedList",
            "blockQuote",
            "|",
            "undo",
            "redo",
            "|",
            "imageUpload",
            "|",
            "insertTable",
            "tableColumn",
            "tableRow",
            "mergeTableCells",
        ],
    },
    language: "vn",
};

const editorElement = document.querySelector("#editor");
if (editorElement) {
    ClassicEditor
        .create(editorElement, {
            simpleUpload: {
                uploadUrl: "/upload",
                withCredentials: true,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
            },
            image: {
                toolbar: [
                    "imageStyle:inline",
                    "imageStyle:block",
                    "imageStyle:side",
                    "|",
                    "imageTextAlternative",
                ],
                resizeOptions: [
                    { name: 'resizeImage:original', value: null, label: 'Original' },
                    { name: 'resizeImage:custom', label: 'Custom', value: 'custom' },
                    { name: 'resizeImage:40', value: '40', label: '40%' },
                    { name: 'resizeImage:60', value: '60', label: '60%' },
                ],
            },
        })
        .then((editor) => {
            console.log("Editor was initialized", editor);
        })
        .catch((error) => {
            console.error(error.stack);
        });
}
