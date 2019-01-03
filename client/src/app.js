import React, { Component } from 'react';
import { Query } from 'react-apollo';
import gql from 'graphql-tag';
import Folder from './folder';
import './app.scss';

class App extends Component {
    render() {
        return (
            <Query
                query={gql`
                      {
                          folders {
                              id
                              name
                              tasks {
                                  id
                                  text
                                  user {
                                      id
                                      name
                                  }
                              }
                          }
                      }
                `}
            >
                {({ loading, error, data }) => {
                    if (loading) return <p>Loading...</p>;
                    if (error) return <p>Error :(</p>;

                    return (
                        <div className="app">
                            <div className="app-container">
                                {data.folders.map((folder) => {
                                    return (
                                        <Folder key={folder.id} name={folder.name} tasks={folder.tasks} />
                                    );
                                })}
                            </div>
                        </div>
                    );
                }}
            </Query>
        );
    }
}

export default App;
