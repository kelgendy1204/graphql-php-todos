import React, { Component } from 'react';
import './task.scss';

class Task extends Component {
    render() {
        return (
            <div className="task-card">
                <div className="task-header">
                    <span>
                        Assignee name
                    </span>
                    <button>
                        X
                    </button>
                </div>
                <div className="task-body">
                    Task body
                </div>
            </div>
        );
    }
}

export default Task;
