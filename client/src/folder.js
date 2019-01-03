import React, { Component } from 'react';
import Task from './task';
import './folder.scss';

class Folder extends Component {
    render() {
        return (
            <div className="folder">
                <h1>{this.props.name}</h1>
                <div className="task-container">
                    {this.props.tasks.map(task => {
                        return <Task key={task.id} task={task} />;
                    })}
                </div>
            </div>
        );
    }
}

export default Folder;
