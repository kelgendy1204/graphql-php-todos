import React, { Component } from 'react';
import './task.scss';

class Task extends Component {
    render() {
        return (
            <div className="task-card">
                <div className="task-header">
                    <span>
                        {this.props.task.id} : {this.props.task.user.name}
                    </span>
                    <button>
                        X
                    </button>
                </div>
                <div className="task-body">
                    {this.props.task.text}
                </div>
            </div>
        );
    }
}

export default Task;
