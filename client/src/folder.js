import React, { Component } from 'react';
import Task from './task';
import './folder.scss';

class Folder extends Component {
    render() {
        return (
            <div className="folder">
                <h1>
                    Folder Title
                </h1>
                <div className="task-container">
                    <Task />
                    <Task />
                    <Task />
                    <Task />
                    <Task />
                    <Task />
                </div>
            </div>
        );
    }
}

export default Folder;
