/**
 * Copyright 2022 Design Barn Inc.
 */

import apiFetch from '@wordpress/api-fetch';

import { IErrorProps } from '../admin/settings/interfaces';
import { IHNResponseProps } from '../admin/settings/reducer';

const path: string = '/lottiefiles/v1/settings/';

// Fetch settings via the REST API endpoint
export const getSettings = async (): Promise<IHNResponseProps | boolean | IErrorProps> => {
  const data = await apiFetch({
    path,
    method: 'GET',
  }).catch((err: IErrorProps) => ({ ...err, error: true }));

  return data as boolean | IHNResponseProps | IErrorProps;
};

// Update settings via the REST API endpoint
export const updateSettings = async (data: IHNResponseProps): Promise<unknown> => {
  const updatedData = apiFetch({
    path,
    data,
    method: 'POST',
  }).catch((err: IErrorProps) => ({ ...err, error: true }));

  return updatedData as unknown;
};
// Delete settings via the REST API endpoint
export const deleteSettings = async (data: IArguments): Promise<unknown> => {
  const deleteData = apiFetch({
    path,
    data,
    method: 'DELETE',
  }).catch((err: IErrorProps) => ({ ...err, error: true }));

  return deleteData as unknown;
};
