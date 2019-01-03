import React, { Component } from 'react';
import './task.scss';

class Task extends Component {
    render() {
        return (
            <div className="task-card">
                <div className="task-header">
                    Task header
                </div>
                <div className="task-body">
                    Task body
                </div>
            </div>
        );
    }
}

export default Task;
