import "../scss/app.scss";

import Blur from "./components/common/Blur";
import Sidebar from "./components/common/Sidebar";
import BlurSidebarManager from "./components/common/BlurSidebarManager";
import NotesManager from "./components/notes/NotesManager";

const sidebar_wrapper_el = document.getElementsByClassName('sidebar-wrapper')[0];
const sidebar_el = document.getElementsByClassName('sidebar__content')[0];
const sidebar_close_button_el = sidebar_wrapper_el.getElementsByTagName('button')[0];
const sidebar = new Sidebar(sidebar_wrapper_el, sidebar_el, sidebar_close_button_el);

const blur_el = document.getElementsByClassName('blur')[0];
const blur = new Blur(blur_el);

const blur_sidebar_manager = new BlurSidebarManager(blur, sidebar);

const notes = document.getElementsByClassName('notes-list__item');
const notes_manager = new NotesManager(notes, blur_sidebar_manager); 

window.app = {};
window.app.sidebar = sidebar;
window.app.blur = blur;
window.app.blur_sidebar_manager = blur_sidebar_manager;